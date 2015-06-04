<?php

namespace ZaLaravel\LaravelGallery\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use ZaLaravel\LaravelGallery\Facades\ImageUploadFacade;
use ZaLaravel\LaravelGallery\Models\GalleryAttachment;
use ZaLaravel\LaravelGallery\Models\Interfaces\GalleryAttachmentInterface;
use ZaLaravel\LaravelGallery\Models\Interfaces\GalleryInterface;
use ZaLaravel\LaravelGallery\Requests\GalleryRequest;


/**
 * Class AdminGalleryController
 * @package ZaLaravel\LaravelGallery\Controllers
 */
class AdminGalleryController extends Controller {

    /**
     * @param GalleryInterface $gallery
     * @return \Illuminate\View\View
     */
	public function index(GalleryInterface $gallery)
	{
        $galleries = $gallery::orderBy('id', 'desc')->paginate(10);
        return view('laravel-gallery::index', compact('galleries'));
	}

    /**
     * @param GalleryInterface $gallery
     * @return \Illuminate\View\View
     */
	public function create(GalleryInterface $gallery)
	{
        Session::forget('gallery_hash');
        return view('laravel-gallery::create', ['gallery' => $gallery]);
	}

    /**
     * @param GalleryInterface $gallery
     * @param GalleryAttachmentInterface $galleryatt
     * @param GalleryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function store(GalleryInterface $gallery,GalleryAttachmentInterface $galleryatt, GalleryRequest $request)
	{
        $hash = Session::get('gallery_hash');
        $gallery->fill($request->input());
        $gallery->attachment_hash = $hash;
        $gallery->save();
        Session::forget('gallery_hash');

        $attachments = $galleryatt::where('hash', $hash )->get();

        foreach ($attachments as $attachment) {
            $attachment->update([
                'comment' => \Input::get($attachment->id),
                'link' => \Input::get('link'.$attachment->id)
            ]);
        }

        return redirect()->route('admin.gallery.index');
	}

    /**
     * @param Request $request
     * @Post("/gallery/upload")
     * @Patch("/gallery/upload")
     */
    public function upload(Request $request) {
        if (!Session::has('gallery_hash')) {
            Session::put('gallery_hash', md5(time()));
        }

        return Response::json([
            'attachment' => ImageUploadFacade::attachmentUpload($request->file('upl'), new GalleryAttachment(), 'gallery', true)
        ]);
    }

    /**
     * @param $id
     *
     * @Delete("/gallery/attachment/{attachment}")
     */
    public function delAttachment($id){
        $status = 'ok';
        $attachment = GalleryAttachmentInterface::find($id);
        if ($attachment) {
            unlink($attachment->path);
            $attachment->delete();
        } else {
            $status = 'Изображение не найдено';
        }

        return Response::json([
            'status' => $status,
            'id' => $id
        ]);
    }

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

    /**
     * @param GalleryInterface $gallery
     * @return \Illuminate\View\View
     */
	public function edit(GalleryInterface $gallery)
	{
        Session::put('gallery_hash', $gallery->attachment_hash);
        $attachments = GalleryAttachmentInterface::where('hash', $gallery->attachment_hash)->get();
        return view('laravel-gallery::edit', [
            'gallery' => $gallery,
            'attachments' => $attachments
        ]);
	}

    /**
     * @param GalleryInterface $gallery
     * @param GalleryRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
	public function update(GalleryInterface $gallery, GalleryRequest $request)
	{
        $gallery->update($request->input());
        $hash = Session::get('gallery_hash');

        $attachments = GalleryAttachment::where('hash', $hash )->get();

        foreach ($attachments as $attachment) {
            $attachment->update([
                'comment' => \Input::get($attachment->id),
                'link' => \Input::get('link'.$attachment->id)
            ]);
        }

        Session::forget('gallery_hash');
        Session::flash('message', 'Галлерея обновлена');
        return redirect()->route('admin.gallery.index');
	}

    /**
     * @param GalleryInterface $gallery
     * @return \Illuminate\Http\RedirectResponse
     */
	public function destroy(GalleryInterface $gallery)
	{
        $gallery->delete();
        Session::flash('message', 'Галлерея удалена');
        return redirect()->route('admin.gallery.index');
	}

}
