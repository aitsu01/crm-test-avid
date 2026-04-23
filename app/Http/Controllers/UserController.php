<?php

namespace App\Http\Controllers;

use App\Forms\UserForm;
use App\Http\Requests\User\BulkDestroyUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Tables\UserTable;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Inertia\Inertia;

class UserController extends Controller
{
    protected function abortIfNotAdmin(): void
    {
        abort_unless(auth()->check() && auth()->user()->isAdmin(), 403);
    }

    public function index()
    {
        $this->abortIfNotAdmin();

        return Inertia::render('avid/default/Table')
                ->title(__('resources.user.index'))
                ->breadcrumb(__('resources.user.index'))
                ->size('md')
                ->table(UserTable::make());
    }

    public function create()
    {
        $this->abortIfNotAdmin();

        return Inertia::render('avid/default/FormModal')
                ->title(__('resources.user.create'))
                ->breadcrumb(__('resources.user.index'), avidRoute('users.index'))
                ->breadcrumb(__('resources.user.create'))
                ->size('md')
                ->form(
                    UserForm::make()
                        ->submit(avidRoute('users.store'))
                        ->cancel(avidRoute('users.index'))
                        ->post()
                );
    }

    public function store(StoreUserRequest $request)
    {
        $this->abortIfNotAdmin();

        $data = $request->validated();
        $data['password'] = Str::password(24);

        $user = User::create($data);

        $status = Password::sendResetLink([
            'email' => $user->email,
        ]);

        if ($status !== Password::RESET_LINK_SENT) {
            return back()->error('Utente creato, ma invio email di reset non riuscito.');
        }

        return redirect(avidRoute('users.index'))
            ->success('Utente creato. È stata inviata una mail per impostare la password.');
    }

    public function show(User $user)
    {
        $this->abortIfNotAdmin();
    }

    public function edit(User $user)
    {
        $this->abortIfNotAdmin();

        return Inertia::render('avid/default/FormModal')
                ->title(__('resources.user.edit'))
                ->breadcrumb(__('resources.user.index'), avidRoute('users.index'))
                ->breadcrumb(__('resources.user.edit'))
                ->size('md')
                ->form(
                    UserForm::make()
                        ->submit(avidRoute('users.update', $user))
                        ->cancel(avidRoute('users.index'))
                        ->defaultData($user)
                        ->put()
                );
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $this->abortIfNotAdmin();

        $user->update($request->validated());

        return redirect(avidRoute('users.index'))->success(__('resources.user.update'));
    }

    public function destroy(User $user)
    {
        $this->abortIfNotAdmin();

        $user->delete();

        return back()->success(__('resources.user.destroy'));
    }

    public function bulkDestroy(BulkDestroyUserRequest $request)
    {
        $this->abortIfNotAdmin();

        User::query()
            ->whereIn('id', $request->validated('selection'))
            ->get()
            ->each(fn (User $user) => $user->delete());

        return back()->success(__('resources.user.bulk_destroy'));
    }
}