<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as Image;
use Illuminate\Support\Facades\File;


class HomeController extends Controller
{
    public function HomeSlider()
    {
        $sliders = DB::table('sliders')->get();
        return view('pages.slider.index', compact('sliders'));
    }

    public function AddSlide()
    {
        return view('pages.slider.create');
    }

    public function StoreSlide(Request $request)
    {
        $validated = $request->validate(
            [
                'image' => 'required|mimes:jpg,jpeg,png',
            ],

        );

        $slider_image = $request->file('image');

        $name_gen = hexdec(uniqid());
        $img_ext = strtolower($slider_image->getClientOriginalExtension());
        $img_name = $name_gen . '.' . $img_ext;
        $up_location = 'images/slides/';
        $last_img = $up_location . $img_name;
        $slider_image->move($up_location, $img_name);

        $data = array();
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['title_en'] = $request->title_en;
        $data['description_en'] = $request->description_en;
        $data['image'] = url($up_location) . '/' . $img_name;
        $data['created_at'] = Carbon::now();
        DB::table('sliders')->insert($data);

        return Redirect()->route('slider.home')->with('success', 'Slide ajouté avec succès');
    }

    public function EditSlide($id)
    {
        $slider = DB::table('sliders')->where('id', $id)->first();
        return view('pages.slider.edit', compact('slider'));
    }

    public function UpdateSlide(Request $request, $id)
    {
        $data = array();
        $data['title'] = $request->title;
        $data['description'] = $request->description;
        $data['title_en'] = $request->title_en;
        $data['description_en'] = $request->description_en;

        if ($request->has('image')) {
            $old_image = $request->oldimage;
            $actu_image = $request->file('image');
            $name_gen = hexdec(uniqid());
            $img_ext = strtolower($actu_image->getClientOriginalExtension());
            $img_name = $name_gen . '.' . $img_ext;
            $up_location = 'images/slides/';
            $actu_image->move($up_location, $img_name);

            $path = parse_url($old_image);
            File::delete(public_path($path['path']));

            $data['image'] = url($up_location) . '/' . $img_name;
        }

        DB::table('sliders')->where('id', $id)->update($data);
        return Redirect()->route('slider.home')->with('success', 'Slide modifié avec succès');
    }

    public function DeleteSlide($id)
    {

        $slider = DB::table('sliders')->where('id', $id)->first();
        $path = parse_url($slider->image);
        File::delete(public_path($path['path']));

        DB::table('sliders')->where('id', $id)->delete();

        return Redirect()->route('slider.home')->with('success', 'Slide supprimé avec succès');;
    }


    public function HomePartenaires()
{
    $partenaires = DB::table('partenaires')->get();

    if (is_null($partenaires)) {
        \Log::error('La variable $partenaires est nulle.', ['userId' => auth()->user()->id]);
        abort(500, 'Erreur interne du serveur');
    }

    if (is_array($partenaires) || is_object($partenaires)) {
        return view('pages.partenaire.index', compact('partenaires'));
    } else {
        \Log::error('La variable $partenaires n\'est pas un tableau ni un objet.', ['userId' => auth()->user()->id, 'partenaires' => $partenaires]);
        return view('pages.partenaire.index')->with('error', 'Erreur lors de la récupération des partenaires');
    }
}


public function StorePartenaires(Request $request)
{
    // Vérification si 'image' est présent dans la requête
    if (!$request->hasFile('image')) {
        \Log::error('La variable $image est nulle.', ['userId' => auth()->user()->id]);
        return Redirect()->back()->with('error', 'Aucun fichier image trouvé dans la requête.');
    }

    $images = $request->file('image');

    // Vérification si $images est un tableau
    if (!is_array($images)) {
        \Log::error('La variable $images n\'est pas un tableau.', ['userId' => auth()->user()->id, 'images' => $images]);
        return Redirect()->back()->with('error', 'Le format des images est incorrect.');
    }

    foreach ($images as $multi) {
        $name_gen = hexdec(uniqid()) . '.' . $multi->getClientOriginalExtension();
        Image::make($multi)->resize(300, 300)->save('images/partenaires/' . $name_gen);

        $last_img = 'images/partenaires/' . $name_gen;

        $data = array();
        $data['image'] = url('images/partenaires/') . '/' . $name_gen;
        $data['created_at'] = Carbon::now();
        DB::table('partenaires')->insert($data);
    }

    return Redirect()->back()->with('success', 'Partenaires insérés avec succès');
}


    public function DeletePartenaire($id)
    {

        $partenaires = DB::table('partenaires')->where('id', $id)->first();
        $path = parse_url($partenaires->image);
        File::delete(public_path($path['path']));

        DB::table('partenaires')->where('id', $id)->delete();

        return Redirect()->route('partenaires.home')->with('success', 'Partenaire supprimé avec succès');
    }



    public function HomeChiffre()
    {

        $chiffres = DB::table('chiffres')->first();
        return view('pages.chiffre.index', compact('chiffres'));
    }

    public function EditChiffre($id)
    {
        $chiffre = DB::table('chiffres')->where('id', $id)->first();
        return view('admin.chiffre.edit', compact('chiffre'));
    }

    public function UpdateChiffre(Request $request, $id)
    {

        $data = array();
        $data['title'] = $request->title;
        $data['description'] = $request->description;

        $oldimage = $request->oldimage;
        $image = $request->image;
        if ($image) {
            $image_one = uniqid() . '.' . $image->getClientOriginalExtension();
            Image::make($image)->resize(500, 300)->save('images/chiffres/' . $image_one);
            $data['image'] = url('images/chiffres/') . '/' . $image_one;
            DB::table('chiffres')->where('id', $id)->update($data);
            
            $path = parse_url($oldimage);
            File::delete(public_path($path['path']));

            return Redirect()->route('home.chiffre')->with('success', 'Chiffres modifié avec succès');
        } else {

            $data['image'] = $oldimage;
            DB::table('chiffres')->where('id', $id)->update($data);
            return Redirect()->back()->with('success', 'Chiffres modifié avec succès');
        }
    }
}

