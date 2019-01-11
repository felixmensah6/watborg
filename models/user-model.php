<?php

/*
 |-----------------------------------------------------------------
 | User Model
 |-----------------------------------------------------------------
 */

class User_Model extends Model
{
    /**
     * Fetch User Data
     * --------------------------------------------
     *
     * @param string $userid The user's id
     * @return array
     */
    public function user_info($userid)
    {
        return $this->db
                    ->columns('*')
                    ->from('users')
                    ->where('user_id = ?')
                    ->select([$userid]);
    }

    /**
     * Fetch Login User Data
     * --------------------------------------------
     *
     * @param string $username The user's username
     * @return array
     */
    public function login_user_info($username)
    {
        return $this->db
                    ->columns('*')
                    ->from('users')
                    ->where('username = ?')
                    ->select([$username]);
    }

    /**
     * Update Login Attempts
     * --------------------------------------------
     *
     * @param string $username The user's username
     * @return void
     */
    public function update_login_attempts($username)
    {
        $this->db
             ->table('users')
             ->set(['login_attempts' => 'login_attempts - 1'])
             ->where('username = ?')
             ->update([$username]);
    }

    /**
     * Successful Login
     * --------------------------------------------
     *
     * @param string $date The date and time logged in
     * @param string $username The user's username
     * @return void
     */
    public function reset_login_flags($date, $username)
    {
        $this->db
             ->table('users')
             ->set([
                 'login_date' => '?',
                 'login_attempts' => '?'
             ])
             ->where('username = ?')
             ->update([$date, 3, $username]);
    }

    /**
     * Lock User Account
     * --------------------------------------------
     *
     * @param string $username The user's username
     * @return void
     */
    public function update_lock_status($username)
    {
        $this->db
             ->table('users')
             ->set(['locked' => '?'])
             ->where('username = ?')
             ->update([1, $username]);
    }

     /**
 	  * Create New User
 	  * --------------------------------------------
      *
      * @return void
 	  */
     public function insert_user()
     {
         $values = func_get_args();
         $this->db
              ->table('users')
              ->columns([
                  'username',
                  'password',
                  'title',
                  'firstname',
                  'lastname',
                  'email',
                  'role',
                  'joined_date',
                  'privilege_create',
                  'privilege_update',
                  'privilege_trash',
                  'temp_password'
              ], true)
              ->insert($values);
     }

     /**
 	   * Update User Account
 	   * --------------------------------------------
       *
       * @return void
 	   */
     public function update_user_account()
     {
         $values = func_get_args();
         $this->db
              ->table('users')
              ->set([
                 'title' => '?',
                 'firstname' => '?',
                 'lastname' => '?',
                 'role' => '?',
                 'privilege_create' => '?',
                 'privilege_update' => '?',
                 'privilege_trash' => '?',
                 'login_attempts' => '?',
                 'locked' => '?'])
              ->where('user_id = ?')
              ->update($values);
     }

     /**
 	  * Delete User Data
 	  * --------------------------------------------
      *
      * @return void
 	  */
     public function delete_user($user_id)
     {
         $this->db
              ->table('users')
              ->where('user_id = ?')
              ->delete([$user_id]);
     }
}
