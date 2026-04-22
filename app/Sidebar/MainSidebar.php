<?php

namespace App\Sidebar;

use Ingenia\Avid\Facades\Avid;
use Ingenia\Avid\Sidebar\Components\Group;
use Ingenia\Avid\Sidebar\Components\Item;
use Ingenia\Avid\Sidebar\Contracts\SidebarExtender;
use Ingenia\Avid\Sidebar\Sidebar;

class MainSidebar implements SidebarExtender
{
    public function extend(Sidebar $sidebar): void
    {
        $sidebar->group('Home', function (Group $group) {
            $group->hide();

            $group->item('Dashboard', function (Item $item) {
                $item->route(Avid::getHome());
                $item->icon('pi pi-home');
            });

            $group->item('Utenti', function (Item $item) {
                $item->route('users.index');
                $item->icon('pi pi-home');
            });

            $group->item('Progetti', function (Item $item) {
                $item->route('projects.index');
                $item->icon('pi pi-briefcase');
            });

            $group->item('Tasks', function (Item $item) {
    $item->route('tasks.index');
    $item->icon('pi pi-check-square');
});



            $group->item('Logout', function (Item $item) {
    $item->route('logout.link');
    $item->icon('pi pi-sign-out');
});

          



        });

            

        

    }
}
