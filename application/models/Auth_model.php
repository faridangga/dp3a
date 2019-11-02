<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth_model extends CI_Model
{
    //input values
    public function input_values()
    {
        $data = array(
            'username' => $this->input->post('username', true),
            'email' => $this->input->post('email', true),
            'password' => $this->input->post('password', true)
        );
        return $data;
    }

    //change password input values
    public function change_password_input_values()
    {
        $data = array(
            'old_password' => $this->input->post('old_password', true),
            'password' => $this->input->post('password', true),
            'password_confirmation' => $this->input->post('password_confirmation', true)
        );
        return $data;
    }

    //login
    public function login()
    {
        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);

        if (!empty($user)) {

            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                return false;
            }

            if ($user->status == 0) {
                return "banned";
            }

            //set user data
            $user_data = array(
                'vr_sess_user_id' => $user->id,
                'vr_sess_user_email' => $user->email,
                'vr_sess_user_role' => $user->role,
                'vr_sess_logged_in' => true,
                'vr_sess_app_key' => $this->config->item('app_key'),
            );

            $this->session->set_userdata($user_data);
            return "success";

        } else {
            return false;
        }

    }

    //admin login
    public function admin_login()
    {
        $data = $this->input_values();
        $user = $this->get_user_by_email($data['email']);

        if (!empty($user)) {

            //check password
            if (!$this->bcrypt->check_password($data['password'], $user->password)) {
                return false;
            }

            if ($user->role != "admin" && $user->role != "author") {
                return false;
            }

            //set user data
            $user_data = array(
                'vr_sess_user_id' => $user->id,
                'vr_sess_user_email' => $user->email,
                'vr_sess_user_role' => $user->role,
                'vr_sess_logged_in' => true,
                'vr_sess_admin_logged_in' => true,
                'vr_sess_app_key' => $this->config->item('app_key'),
            );

            $this->session->set_userdata($user_data);

            return true;
        } else {
            return false;
        }
    }


    //login direct
    public function login_direct($user)
    {
        //set user data
        $user_data = array(
            'vr_sess_user_id' => $user->id,
            'vr_sess_user_email' => $user->email,
            'vr_sess_user_role' => $user->role,
            'vr_sess_logged_in' => true,
            'vr_sess_app_key' => $this->config->item('app_key'),
        );

        $this->session->set_userdata($user_data);
    }

    //login with facebook
    public function login_with_facebook()
    {
        $id = $this->input->post('id', true);
        $email = $this->input->post('email', true);
        $first_name = $this->input->post('first_name', true);
        $last_name = $this->input->post('last_name', true);


        $user = $this->get_user_by_email($email);

        //check if user registered
        if (empty($user)) {

            //add user to database
            $data = array(
                'facebook_id' => $id,
                'email' => $email,
                'username' => $first_name . " " . $last_name,
                'slug' => str_slug($first_name . " " . $last_name . "-" . uniqid()),
                'avatar' => "https://graph.facebook.com/" . $id . "/picture?type=large",
                'user_type' => "facebook",
            );

            if (!empty($data['email'])) {
                $this->db->insert('users', $data);
                $user = $this->get_user_by_email($email);
                $this->login_direct($user);
            }

        } else {
            //login
            $this->login_direct($user);
        }
    }

    //login with google
    public function login_with_google()
    {
        $id = $this->input->post('id', true);
        $email = $this->input->post('email', true);
        $name = $this->input->post('name', true);
        $avatar = $this->input->post('avatar', true);

        $user = $this->get_user_by_email($email);

        //check if user registered
        if (empty($user)) {

            //add user to database
            $data = array(
                'google_id' => $id,
                'email' => $email,
                'username' => $name,
                'slug' => str_slug($name . "-" . uniqid()),
                'avatar' => $avatar,
                'user_type' => "google",
            );

            if (!empty($data['email'])) {
                $this->db->insert('users', $data);
                $user = $this->get_user_by_email($email);
                $this->login_direct($user);
            }

        } else {
            //login
            $this->login_direct($user);
        }
    }

    //register
    public function register()
    {
        $data = $this->auth_model->input_values();
        //secure password
        $data['password'] = $this->bcrypt->hash_password($data['password']);
        $data['user_type'] = "registered";
        $data["slug"] = str_slug($data["username"] . "-" . uniqid());
        $data['handphone'] = $this->input->post('handphone', true);
        $data['position'] = $this->input->post('position', true);
        

        if ($this->db->insert('users', $data)) {
            $last_id = $this->db->insert_id();
            return $this->get_user($last_id);
        } else {
            return false;
        }
    }

    //logout
    public function logout()
    {
        //unset user data
        $this->session->unset_userdata('vr_sess_user_id');
        $this->session->unset_userdata('vr_sess_user_email');
        $this->session->unset_userdata('vr_sess_user_role');
        $this->session->unset_userdata('vr_sess_logged_in');
        $this->session->unset_userdata('vr_sess_admin_logged_in');
        $this->session->unset_userdata('vr_sess_app_key');
        helper_deletecookie("varient_user_id");
        $this->session->sess_destroy();
    }

    //update user
    public function update_user($id)
    {
        $user = $this->get_user($id);

        $data = array(
            'username' => $this->input->post('username', true),
            'province_id' => $this->input->post('province_id', true),
            'position' => $this->input->post('position', true),
        );

        //get file
        $file = $_FILES['file'];
        if (!empty($file['name'])) {

            //delete old
            delete_image_from_server($user->avatar);

            //upload new
            $data["avatar"] = $this->upload_model->avatar_upload($id, $file);
        }

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //update author
    public function update_author($id)
    {
        $user = $this->get_user($id);

        $data = array(
            'username' => $this->input->post('username', true),
            'slug' => $this->input->post('slug', true),
            'about_me' => $this->input->post('about_me', true),
            'facebook_url' => $this->input->post('facebook_url', true),
            'twitter_url' => $this->input->post('twitter_url', true),
            'google_url' => $this->input->post('google_url', true),
            'instagram_url' => $this->input->post('instagram_url', true),
            'pinterest_url' => $this->input->post('pinterest_url', true),
            'linkedin_url' => $this->input->post('linkedin_url', true),
            'vk_url' => $this->input->post('vk_url', true),
            'youtube_url' => $this->input->post('youtube_url', true),
        );

        //get file
        $file = $_FILES['file'];
        if (!empty($file['name'])) {

            //delete old
            delete_image_from_server($user->avatar);

            //upload new
            $data["avatar"] = $this->upload_model->avatar_upload($id, $file);
        }

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //change password
    public function change_password($old_password_empty)
    {
        $user = user();

        if (!empty($user)) {

            $data = $this->change_password_input_values();

            if ($old_password_empty == 1) {
                //password does not match stored password.
                if (!$this->bcrypt->check_password($data['old_password'], $user->password)) {
                    $this->session->set_flashdata('error', html_escape(trans("wrong_password_error")));
                    $this->session->set_flashdata('form_data', $this->change_password_input_values());
                    redirect($this->agent->referrer());
                }
            }

            $data = array(
                'password' => $this->bcrypt->hash_password($data['password'])
            );

            $this->db->where('id', $user->id);
            return $this->db->update('users', $data);

        } else {
            return false;
        }
    }

    //reset password
    public function reset_password($email)
    {
        //generate new password
        $new_password = bin2hex(openssl_random_pseudo_bytes(3));

        $data = array(
            'password' => $this->bcrypt->hash_password($new_password)
        );

        //change password
        $this->db->where('email', $email);
        $this->db->update('users', $data);
        return $new_password;
    }

    //change user role
    public function change_user_role($id, $role)
    {
        $data = array(
            'role' => $role
        );

        $this->db->where('id', $id);
        return $this->db->update('users', $data);
    }

    //delete user
    public function delete_user($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {
            $this->db->where('id', $id);
            return $this->db->delete('users');
        } else {
            return false;
        }
    }

    //ban user
    public function ban_user($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 0
            );

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //remove user ban
    public function remove_user_ban($id)
    {
        $user = $this->get_user($id);

        if (!empty($user)) {

            $data = array(
                'status' => 1
            );

            $this->db->where('id', $id);
            return $this->db->update('users', $data);
        } else {
            return false;
        }
    }

    //is logged in
    public function is_logged_in()
    {
        //check if user logged in
        if ($this->session->userdata('vr_sess_logged_in') == true &&
            $this->session->userdata('vr_sess_app_key') == $this->config->item('app_key') &&
            !empty($this->get_user($this->session->userdata('vr_sess_user_id')))) {
            return true;
        } else {
            return false;
        }
    }

    //function get user
    public function get_logged_user()
    {
        if ($this->is_logged_in()) {
            $this->db->where('id', $this->session->userdata('vr_sess_user_id'));
            $query = $this->db->get('users');
            return $query->row();
        }
    }

    //is admin
    public function is_admin()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if (user()->role == 'admin') {
            return true;
        } else {
            return false;
        }
    }

    //is author
    public function is_author()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if (user()->role == 'author') {
            return true;
        } else {
            return false;
        }
    }

    //show admin paneş
    public function show_admin_panel()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        //check role
        if ($this->session->userdata('vr_sess_admin_logged_in') == true) {
            return true;
        } else {
            return false;
        }
    }

    //get user by id
    public function get_user($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by email
    public function get_user_by_email($email)
    {
        $this->db->where('email', $email);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get user by slug
    public function get_user_by_slug($slug)
    {
        $this->db->where('slug', $slug);
        $query = $this->db->get('users');
        return $query->row();
    }

    //get users
    public function get_users()
    {
        $query = $this->db->get('users');
        return $query->result();
    }

    //get authors
    public function get_authors()
    {
        $this->db->where('role !=', 'user');
        $query = $this->db->get('users');
        return $query->result();
    }

    //get last users
    public function get_last_users()
    {
        $this->db->order_by('users.id', 'DESC');
        $this->db->limit(7);
        $query = $this->db->get('users');
        return $query->result();
    }

    //user count
    public function get_user_count()
    {
        $query = $this->db->get('users');
        return $query->num_rows();
    }

    //get logged user id
    public function get_user_id()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        return user()->id;
    }

    //get logged username
    public function get_username()
    {
        //check logged in
        if (!$this->is_logged_in()) {
            return false;
        }

        return user()->id;
    }

    //check if email is unique
    public function is_unique_email($email, $user_id = 0)
    {
        $user = $this->auth_model->get_user_by_email($email);

        //if id doesnt exists
        if ($user_id == 0) {
            if (empty($user)) {
                return true;
            } else {
                return false;
            }
        }

        if ($user_id != 0) {
            if (!empty($user) && $user->id != $user_id) {
                //email taken
                return false;
            } else {
                return true;
            }
        }
    }

    //remember me
    public function remember_me($user_id)
    {
        helper_setcookie("varient_user_id", $user_id);
    }

    public function add_point($point=1)
    {

        $this->db->set('point', 'point+' . $point, FALSE);
        $this->db->where('id', user()->id);
        return $this->db->update('users');
           
    }

    public function update_user_point($user_id, $point)
    {
        $this->db->set('point', $point);
        $this->db->where('id', $user_id);
        $this->db->where_not_in('id', 870);
        return $this->db->update('users');
    }

    public function get_top_learner($limit=53)
    {
        
        $this->db->where('role', 'user');
        $this->db->where_not_in('id', 870);
        $this->db->order_by('users.point', 'DESC');
        return $this->db->get('users', $limit, 0);
    }
}
