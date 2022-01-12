<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BlogUserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */

    public function updating(User $user)
    {

        $this->deleteRole($user);
        $this->setUpdatePassword($user);

    }

    /**
     * password update via admin-panel
     */

    protected function setUpdatePassword(User $user)
    {

        if(!empty($user['password'])){
            $user['password'] = Hash::make($user['password']);
        }else{
            $user = Arr::except($user,array('password'));
        }
    }


    protected function deleteRole(User $user)
    {
        DB::table('model_has_roles')->where('model_id',$user->id)->delete();

    }


    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
