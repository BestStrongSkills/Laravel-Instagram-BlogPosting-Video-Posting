<?php

namespace App\Http\Controllers;
use App;
use Illuminate\Http\Request;
use Vinkla\Instagram\Instagram as OldInstagram;
use Exception;
use Illuminate\Support\Facades\Storage;
use MetzWeb\Instagram\Instagram;
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    private $instagram;
    public function __construct()
    {
        $this->instagram = new Instagram(array(
            'apiKey' => config('instagram.client_id'),
            'apiSecret' => config('instagram.client_secret'),
            'apiCallback' => config('instagram.callback_url')
        ));
    }
    public function index()
    {
        return redirect($this->instagram->getLoginUrl(array(
            'basic'
        )));
    }
    public function instagramCallback(Request $request) {
        $code = $request->code;
        $data = $this->instagram->getOAuthToken($code);
        return redirect()->route('showGallery',['token'=>$data->access_token]);
    }
    public function showGallery($token='none',Request $request)
    {
        try{
            $instagram = new OldInstagram($token);
            $data = $instagram->get();
            return view('gallery',compact('data','token'));
        }
        catch(Exception $ex)
        {
            return redirect('/')->with('error',$ex->getMessage());
        }
    }
    public function view($token='none',Request $request)
    {
        $instagram = new OldInstagram($token);
        $data = $instagram->get();
        $urls = Request('image');
        $files = Storage::files('images/');
        foreach ($files as $file) {
            Storage::delete($file);
        }
        $imageC = 0;
        $videoC = 0;
        $videoName = array();
        if($urls)
        {
            foreach ($urls as $id) {
                foreach ($data as $inst) {
                    if($inst->id == $id){
                        if($inst->type=='image')
                        {
                            $url = $inst->images->low_resolution->url;
                            $imageC++;
                            $filename = 'img'.$imageC.'.jpg';
                        }
                        elseif ($inst->type=='video') {
                            $url = $inst->videos->low_resolution->url;
                            $videoC++;
                            $filename = 'video'.$videoC.'.'.pathinfo($url,PATHINFO_EXTENSION);
                            $videoName[] = $filename;
                        }
                        $file = file_get_contents($url);
                        $save = file_put_contents('images/'.$filename, $file);
                    }
                }
            }
        }
        if($imageC)
        {
            $file = $request->file('mp3file');
            if ($file)
            {
                $file->move('images/', 'audio.mp3');
                $execStr='ffmpeg -framerate 1/5 -i images/img%d.jpg -t '.(5*$imageC).' -i images/audio.mp3 -c:a aac -strict experimental -b:a 192k -shortest -c:v libx264 -filter_complex scale=iw*min(576/iw\,1024/ih):ih*min(576/iw\,1024/ih),pad=576:1024:(576-iw*min(576/iw\,1024/ih))/2:(1024-ih*min(576/iw\,1024/ih))/2:white -r 30 -pix_fmt yuv420p images/temp.mp4';
            }
            else
                $execStr='ffmpeg -framerate 1/5 -i images/img%d.jpg -c:v libx264 -filter_complex scale=iw*min(576/iw\,1024/ih):ih*min(576/iw\,1024/ih),pad=576:1024:(576-iw*min(576/iw\,1024/ih))/2:(1024-ih*min(576/iw\,1024/ih))/2:white -r 30 -pix_fmt yuv420p images/temp.mp4';
            exec($execStr);
            
            exec('ffmpeg -i images/temp.mp4 -c copy -bsf:v h264_mp4toannexb images/intermediate1.ts');
        }
        for ($i=0; $i < $videoC; $i++)
        {
            exec('ffmpeg -i images/'.$videoName[$videoC-1].' -vf scale=iw*min(576/iw\,1024/ih):ih*min(576/iw\,1024/ih),pad=576:1024:(576-iw*min(576/iw\,1024/ih))/2:(1024-ih*min(576/iw\,1024/ih))/2:white -c:v libx264 -bsf:v h264_mp4toannexb images/intermediate'.($i+2).'.ts');
        }
        exec("(for %i in (images/*.ts) do @echo file '%i') > images/mylist.txt");

        exec("ffmpeg -f concat -i images/mylist.txt -c copy images/output.mp4");
        return view('video');
    }
}
