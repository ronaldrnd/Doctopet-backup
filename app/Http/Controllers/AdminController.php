<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Retourne la page associé à la gestion des utilisateurs côté administrateur
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function ManageUsers()
    {
        return view("admin.manageUsers");
    }

    /**
     * Retourne la page associé aux logs
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function ManageLogs(){
        return view("admin.manageLogs");
    }


    /**
     * Retourne la page associée aux signalements des utilisateurs
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function ManageReports()
    {
        return view("admin.manageReports");
    }

    /**
     * Retourne la page associée à la gestion des Ambassadeur
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function ManageAmbassadeur()
    {
        return view("admin.manageAmbassadeur");
    }

    /**
     *  Page pour gérer les vétérinaires externes
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function ManageVeterinaryExt()
    {
        return view("admin.manageVeterinaryExt");
    }

    /**
     * Page pour gérer un vétérinaire externe
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|object
     */
    public function ViewVeterinaryExt($id)
    {

        return view("admin.viewVeterinaryExt",
        [
            "vetoid" => $id
        ]);
    }

    public function ReviewAvis()
    {
        return view("admin.reviewAvis");
    }

    public function ManageCabinets()
    {
        return view("admin.manageCabinets");
    }

    public function EditCabinet($id)
    {
        return view("admin.editCabinet",
        [
            "id" => $id
        ]);
    }

    public function EditUser($id)
    {

        if (User::find($id) == null)
            return redirect()->route("admin.users")->withErrors(["error" => "User not found"]);

        return view("admin.edituserinfo",
        [
            "id" => $id
        ]);
    }


    public function ErrorFixPrevent()
    {
        return view("admin.error_prevent");
    }

    public function StripeStats()
    {
        return view("admin.stripe_stats");
    }

    public function UserMap()
    {
        return view("admin.userMap");
    }
}

