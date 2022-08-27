<?php

namespace App\Controllers;

class Admin extends BaseController
{
    protected $session;
    protected $userModel;
    protected $projectModel;
    protected $commentModel;
    protected $fileModel;

    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = model('UserModel', true, $db);
        $this->projectModel = model('ProjectModel', true, $db);
        $this->commentModel = model('CommentModel', true, $db);
        $this->fileModel = model('FileModel', true, $db);
    }

    public function index()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        // On Session User Data
        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));

        $projects = $this->projectModel->findAll();

        $data = [
            'projects' => $projects,
            'userData' => $userData
        ];

        return view('admin/projects', $data);
    }

    public function users()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        // On Session User Data
        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));


        $userAccounts = $this->userModel->where('status !=', 'Deleted')->findAll();

        $db      = \Config\Database::connect();
        $builder = $db->table('users');        // 'mytablename' is the name of your table

        $builder->select('instance');       // names of your columns, single string, separated by a comma
        $builder->distinct();       // names of your columns, single string, separated by a comma
        $instances = $builder->get();
        $instances = $instances->getResult();

        $builder->select('position');       // names of your columns, single string, separated by a comma
        $builder->distinct();       // names of your columns, single string, separated by a comma
        $positions = $builder->get();
        $positions = $positions->getResult();
        $data = [
            'userAccounts' => $userAccounts,
            'userData' => $userData,
            'instances' => $instances,
            'positions' => $positions,
        ];


        return view('admin/users', $data);
    }

    public function usersAdd()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
        $instance1 = $_POST['instanceselect'];
        $instance2 = $_POST['instance'];
        $position1 = $_POST['positionselect'];
        $position2 = $_POST['position'];

        $nip = $_POST['nip'];
        $nik = $_POST['nik'];

        if ($instance1 == 'newinstance12345') {
            $instance = $instance2;
        } else {
            $instance = $instance1;
        }

        if ($position1 == 'newposition12345') {
            $position = $position2;
        } else {
            $position = $position1;
        }


        $data = [
            'name' => $name,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_DEFAULT),
            'role' => $role,
            'nip' => $nip,
            'nik' => $nik,
            'instance' => $instance,
            'position' => $position,
        ];

        // print_r($data);
        if (!$this->userModel->find($email)) {
            if ($this->userModel->insert($data)) {
                setcookie("add", 'success', time() + 10);
                return redirect()->to(HOST_URL . '/admin/users');
            } else {
                setcookie("add", 'failed', time() + 10);
                return redirect()->to(HOST_URL . '/admin/users');
            }
        } else {
            setcookie("add", 'exist', time() + 10);
            return redirect()->to(HOST_URL . '/admin/users');
        }
    }

    public function usersGet()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End


        $id = $_POST['id'];

        $data = [
            'id' => $id
        ];

        $user = $this->userModel->where('id', $id)->find();
        return json_encode($user);
    }

    public function usersUpdate()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End


        $id = $_POST['id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $role = $_POST['role'];
        $status = $_POST['status'];

        $instance1 = $_POST['instanceselect'];
        $instance2 = $_POST['instance'];
        $position1 = $_POST['positionselect'];
        $position2 = $_POST['position'];

        $nip = $_POST['nip'];
        $nik = $_POST['nik'];

        if ($instance1 == 'newinstance12345') {
            $instance = $instance2;
        } else {
            $instance = $instance1;
        }

        if ($position1 == 'newposition12345') {
            $position = $position2;
        } else {
            $position = $position1;
        }

        $data = [
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'role' => $role,
            'status' => $status,
            'nip' => $nip,
            'nik' => $nik,
            'instance' => $instance,
            'position' => $position,
        ];

        if ($this->userModel->where('id', $id)->set($data)->update()) {
            setcookie("updated", 'success', time() + 10);
            return redirect()->to(HOST_URL . '/admin/users');
        } else {
            setcookie("updated", 'failed', time() + 10);
            return redirect()->to(HOST_URL . '/admin/users');
        }
    }


    public function usersResetPassword()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $id = $_POST['id'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);

        if ($this->userModel->where('id', $id)->set('password', $password)->update()) {
            setcookie("reset-password", 'success', time() + 10);
            return redirect()->to(HOST_URL . '/admin/users');
        } else {
            setcookie("reset-password", 'failed', time() + 10);
            return redirect()->to(HOST_URL . '/admin/users');
        }
    }

    public function projectsAdd()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $name = $_POST['name'];
        $description = $_POST['description'];

        $data = [
            'name' => $name,
            'description' => $description
        ];

        $this->projectModel->insert($data);
        return redirect()->to(HOST_URL . '/admin/projects');
    }

    public function projectsDetail()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));

        $id = $_GET['id'];

        $projectFiles = $this->fileModel->where('project_id', $id)->findAll();

        $arrayfiles = [];
        foreach ($projectFiles as $key => $file) {
            $user_id = $file['user_id'];
            $userUploaded = $this->userModel->where('id', $user_id)->find();
            $filesData = [
                $key => [
                    'id' => $file['id'],
                    'uploader' => $userUploaded[0]['name'],
                    'user_id' => $file['user_id'],
                    'project_id' => $file['project_id'],
                    'document_name' => $file['document_name'],
                    'file_name' => $file['file_name'],
                    'uploaded_at' => $file['uploaded_at']
                ],
            ];
            $arrayfiles = array_merge($arrayfiles, $filesData);
        }

        $userComment = $this->commentModel->where('project_id', $id)->orderBy('id', 'desc')->findAll();

        $arrayComments = [];
        foreach ($userComment as $key => $comment) {
            $user_id = $comment['user_id'];
            $userCommenting = $this->userModel->where('id', $user_id)->find();
            $commentsData = [
                $key => [
                    'id' => $comment['id'],
                    'user' => $userCommenting[0]['name'],
                    'user_id' => $comment['user_id'],
                    'project_id' => $comment['project_id'],
                    'comment' => $comment['comment'],
                    'commented_at' => $comment['commented_at'],
                ],
            ];
            $arrayComments = array_merge($arrayComments, $commentsData);
        }
        $project = $this->projectModel->find($id);
        $data = [
            'project' => $project,
            'userData' => $userData,
            'commentData' => $arrayComments,
            'files' => $arrayfiles
        ];
        return view('admin/project-detail', $data);
    }

    public function projectsAddComment()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $id = $_POST['userid'];
        $comment = $_POST['comment'];
        $project_id = $_POST['id'];

        $data = [
            'user_id' => $id,
            'comment' => $comment,
            'project_id' => $project_id
        ];
        $this->commentModel->insert($data);
        return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $project_id);
    }

    public function projectsUpdate()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $id = $_POST['project_id'];
        $name = $_POST['name'];
        $description = $_POST['description'];
        $progress = $_POST['progress'];

        $data = [
            'name' => $name,
            'description' => $description,
            'progress' => $progress
        ];

        $this->projectModel->where('id', $id)->set($data)->update();

        return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $id);
    }

    public function projectsUpload()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $user_id = $_POST['user_id'];
        $project_id = $_POST['project_id'];

        $file = $this->request->getFile('file2upload');
        $originalName = $file->getClientName();
        $newName = $file->getRandomName();


        $data = [
            'document_name' => $originalName,
            'file_name' => $newName,
            'project_id' => $project_id,
            'user_id' => $user_id
        ];

        if ($file->move("public/uploads/", $newName)) {
            $this->fileModel->insert($data);
            return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $project_id);
        } else {
            echo "failed";
        }
    }

    public function projectsDownload()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End


        $file_name = $_GET['filename'];
        $fileData = $this->fileModel->where('file_name', $file_name)->findAll();
        $document_name = $fileData[0]['document_name'];


        return $this->response->download('public/uploads/' . $file_name, null)->setFileName($document_name);
    }

    public function projectsDelete()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End


        $file_name = $_GET['filename'];
        $id = $_GET['id'];


        $this->fileModel->where('file_name', $file_name)->delete();
        unlink('public/uploads/' . $file_name);

        return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $id);
    }

    public function commentsDelete()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        // Session Check End

        $id = $_POST['id'];
        $this->commentModel->where('id', $id)->delete();
    }

    public function projectPurge()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }
        $id = $_POST['id'];

        $this->commentModel->where('project_id', $id)->delete();
        $files = $this->fileModel->where('project_id', $id)->find();

        foreach ($files as $index => $file) {
            $file_name = $file['file_name'];
            $this->fileModel->where('file_name', $file_name)->delete();
            unlink('public/uploads/' . $file_name);
        }

        $this->projectModel->where('id', $id)->delete();
    }

    public function usersDelete()
    {

        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }

        $id = $_POST['id'];
        $data = [
            'email' => '',
            'status' => 'Deleted',
            'password' => '',
            'role' => 'Deleted_user'
        ];
        $this->userModel->where('id', $id)->set($data)->update();
    }
}
