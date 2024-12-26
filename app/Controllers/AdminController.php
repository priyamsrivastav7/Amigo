<?php
namespace App\Controllers;

use App\Models\RestaurantModel;

class AdminController extends BaseController
{
    public function dashboard()
    {
        $restaurantModel = new RestaurantModel();
        $restaurants = $restaurantModel->findAll();

        return view('admin/dashboard', ['restaurants' => $restaurants]);
    }

    public function approve($id)
    {
        $restaurantModel = new RestaurantModel();
        $restaurantModel->update($id, ['is_live' => 1]);
        return redirect()->to('/admin/dashboard')->with('message', 'Restaurant approved successfully.');
    }

    public function disapprove($id)
    {
        $restaurantModel = new RestaurantModel();
        $restaurantModel->delete($id);
        return redirect()->to('/admin/dashboard')->with('message', 'Restaurant disapproved and deleted.');
    }

    public function view($id)
    {
        $restaurantModel = new RestaurantModel();
        $restaurant = $restaurantModel->find($id);

        return view('admin_view_restaurant', ['restaurant' => $restaurant]);
    }
}
