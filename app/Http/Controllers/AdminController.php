<?php

namespace App\Http\Controllers;


class AdminController extends Controller
{
    public function index() {
        return view("layouts.cms");
    }
    public function getAdminInfo() {
        $user = auth()->user();
        return response()->json(["success", $user], 200);
    }
}
