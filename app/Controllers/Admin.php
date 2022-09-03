<?php

namespace App\Controllers;

class Admin extends BaseController
{
    protected $session;
    protected $userModel;
    protected $projectModel;
    protected $projectfileModel;
    protected $commentModel;
    protected $eventModel;
    protected $eventfileModel;
    protected $meetingModel;
    protected $attendanceModel;


    function __construct()
    {
        $this->session = \Config\Services::session();
        $this->userModel = model('UserModel', true, $db);
        $this->projectModel = model('ProjectModel', true, $db);
        $this->projectfileModel = model('ProjectFileModel', true, $db);
        $this->commentModel = model('CommentModel', true, $db);
        $this->eventModel = model('EventModel', true, $db);
        $this->eventfileModel = model('EventFileModel', true, $db);
        $this->meetingModel = model('MeetingModel', true, $db);
        $this->attendanceModel = model('AttendanceModel', true, $db);
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
        $builder->where('instance !=', null);      // names of your columns, single string, separated by a comma
        $instances = $builder->get();
        $instances = $instances->getResult();

        $builder->select('position');       // names of your columns, single string, separated by a comma
        $builder->distinct();
        $builder->where('position !=', null);      // names of your columns, single string, separated by a comma
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

        $projectFiles = $this->projectfileModel->where("project_id = $id")->findAll();
        if ($projectFiles == null) {
            return redirect()->to(HOST_URL);
        }

        $arrayfiles = [];
        foreach ($projectFiles as $key => $file) {
            $user_id = $file['user_id'];
            $userUploaded = $this->userModel->where("id = $user_id")->find();
            $filesData = [
                $key => [
                    'id' => $file['id'],
                    'uploader' => $userUploaded[0]['name'],
                    'user_id' => $file['user_id'],
                    'project_id' => $file['project_id'],
                    'document_name' => $file['document_name'],
                    'file_name' => $file['file_name'],
                    'upload_time' => $file['upload_time']
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


        $events = $this->eventModel->where("project_id = $id")->find();


        $data = [
            'project' => $project,
            'userData' => $userData,
            'commentData' => $arrayComments,
            'files' => $arrayfiles,
            'events' => $events
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

        $data = [
            'name' => $name,
            'description' => $description,
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
            $this->projectfileModel->insert($data);
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


        if (isset($_GET['filename'])) {
            $file_name = $_GET['filename'];
            $fileData = $this->projectfileModel->where('file_name', $file_name)->findAll();
            $document_name = $fileData[0]['document_name'];
            return $this->response->download('public/uploads/' . $file_name, null)->setFileName($document_name);
        } else if (isset($_GET['notename'])) {
            $file_name = $_GET['notename'];
            $fileData = $this->noteModel->where('file_name', $file_name)->findAll();
            $document_name = $fileData[0]['document_name'];
            return $this->response->download('public/uploads/notes/' . $file_name, null)->setFileName($document_name);
        }
    }

    public function projectsDelete()
    {



        $id = $_GET['id'];
        if (isset($_GET['filename'])) {
            $file_name = $_GET['filename'];
            $this->projectfileModel->where('file_name', $file_name)->delete();
            unlink('public/uploads/' . $file_name);
        } else if (isset($_GET['notename'])) {
            $file_name = $_GET['notename'];
            $this->noteModel->where('file_name', $file_name)->delete();
            unlink('public/uploads/notes/' . $file_name);
        }
        if (isset($_GET['u'])) {
            return redirect()->to(HOST_URL . '/user/projects/detail?id=' . $id);
        } else {
            return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $id);
        }
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
        $pfiles = $this->projectfileModel->where('project_id', $id)->find();

        foreach ($pfiles as $index => $file) {
            $file_name = $file['file_name'];
            $this->projectfileModel->where('file_name', $file_name)->delete();
            unlink('public/uploads/' . $file_name);
        }

        $events = $this->eventModel->where("project_id", $id)->find();
        foreach ($events as $key => $event) {
            $event_id = $event['id'];
            $efiles = $this->eventfileModel->where('event_id', $event_id)->find();
            foreach ($efiles as $index => $file) {
                $file_name = $file['file_name'];
                $this->eventfileModel->where('file_name', $file_name)->delete();
                unlink('public/uploads/event-files/' . $file_name);
            }
        }

        $this->eventModel->where('project_id', $id)->delete();

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
            'email' => null,
            'status' => 'Deleted',
            'password' => null,
            'role' => 'Deleted_user',
            'nip' => null,
            'nik' => null,
            'position' => null,
            'instance' => null
        ];
        $this->userModel->where('id', $id)->set($data)->update();
    }

    public function projectsNotesUpload()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'User') {
                return redirect()->to(HOST_URL . '/user');
            }
        } else {
            return redirect()->to(HOST_URL . '/login');
        }

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

        if ($file->move("public/uploads/notes/", $newName)) {
            $this->noteModel->insert($data);
            return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $project_id);
        } else {
            echo "failed";
        }
    }

    public function pakhar()
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

        return view('admin/pak-harmonisasi', $data);
    }

    public function addEvent()
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


        $project_id = $_POST['project_id'];
        $name = $_POST['eventName'];
        $date = $_POST['eventDate'];
        $description = $_POST['eventDescription'];

        $tgl = substr($date, 0, 2);
        $bln = substr($date, 3, 2);
        $thn = substr($date, 6, 4);

        $newformat = $thn . '-' . $bln . '-' . $tgl;
        $date = date_format(date_create($newformat), 'Y-m-d');

        $data = [
            'project_id' => $project_id,
            'name' => $name,
            'commit_time' => $date,
            'description' => $description
        ];
        $this->eventModel->insert($data);
        return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $project_id);
    }
    public function editEvent()
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


        $project_id = $_POST['project_id'];
        $event_id = $_POST['event_id'];
        $name = $_POST['eventName'];
        $date = $_POST['eventDate'];
        $description = $_POST['eventDescription'];

        $tgl = substr($date, 0, 2);
        $bln = substr($date, 3, 2);
        $thn = substr($date, 6, 4);

        $newformat = $thn . '-' . $bln . '-' . $tgl;
        $date = date_format(date_create($newformat), 'Y-m-d');

        $data = [
            'name' => $name,
            'commit_time' => $date,
            'description' => $description
        ];
        $this->eventModel->where('id', $event_id)->set($data)->update();
        return redirect()->to(HOST_URL . '/admin/projects/detail?id=' . $project_id);
    }

    public function projectDocuments()
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


        if (isset($_GET['pro']) && $_GET['pro'] != '') {
            $project_id = $_GET['pro'];
            if (isset($_GET['pak'])) {
                $pak_id = $_GET['pak'];
                $docs = $this->pakfilesModel->where('paks_id', $pak_id)->findAll();

                $arrayfiles = [];
                foreach ($docs as $key => $file) {
                    $user_id = $file['user_id'];
                    $userUploaded = $this->userModel->where('id', $user_id)->find();
                    $filesData = [
                        $key => [
                            'id' => $file['id'],
                            'uploader' => $userUploaded[0]['name'],
                            'user_id' => $file['user_id'],
                            'paks_id' => $file['paks_id'],
                            'document_name' => $file['document_name'],
                            'file_name' => $file['file_name'],
                            'uploaded_at' => $file['uploaded_at']
                        ],
                    ];
                    $arrayfiles = array_merge($arrayfiles, $filesData);
                }
            } elseif (isset($_GET['har'])) {
                $har_id = $_GET['har'];
                $docs = $this->harfilesModel->where('hars_id', $har_id)->findAll();

                $arrayfiles = [];
                foreach ($docs as $key => $file) {
                    $user_id = $file['user_id'];
                    $userUploaded = $this->userModel->where('id', $user_id)->find();
                    $filesData = [
                        $key => [
                            'id' => $file['id'],
                            'uploader' => $userUploaded[0]['name'],
                            'user_id' => $file['user_id'],
                            'paks_id' => $file['paks_id'],
                            'document_name' => $file['document_name'],
                            'file_name' => $file['file_name'],
                            'uploaded_at' => $file['uploaded_at']
                        ],
                    ];
                    $arrayfiles = array_merge($arrayfiles, $filesData);
                }
            }
        }
        $data = [
            'userData' => $userData,
            'docs' => $arrayfiles,
        ];

        return view('admin/documents', $data);
    }


    public function projectsEvent()
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


        if (isset($_GET['p']) && isset($_GET['e']) && $_GET['p'] != '' && $_GET['e'] != '') {

            $event_id = $_GET['e'];
            $docs = $this->eventfileModel->where("event_id", $event_id)->find();
            $event = $this->eventModel->where("id", $event_id)->find();


            $arrayfiles = [];
            foreach ($docs as $key => $file) {
                $user_id = $file['user_id'];
                $userUploaded = $this->userModel->where('id', $user_id)->find();
                $filesData = [
                    $key => [
                        'id' => $file['id'],
                        'uploader' => $userUploaded[0]['name'],
                        'user_id' => $file['user_id'],
                        'event_id' => $file['event_id'],
                        'document_name' => $file['document_name'],
                        'file_name' => $file['file_name'],
                        'upload_time' => $file['upload_time']
                    ],
                ];
                $arrayfiles = array_merge($arrayfiles, $filesData);
            }

            $data = [
                'event' => $event,
                'eventfiles' => $arrayfiles,
                'userData' => $userData
            ];

            return view('admin/documents', $data);
        } else {
            return redirect()->to(HOST_URL);
        }
    }

    public function eventsUpload()
    {

        $user_id = $_POST['user_id'];
        $event_id = $_POST['event_id'];
        $project_id = $_POST['project_id'];


        $file = $this->request->getFile('file2upload');
        $originalName = $file->getClientName();
        $newName = $file->getRandomName();


        $data = [
            'document_name' => $originalName,
            'file_name' => $newName,
            'event_id' => $event_id,
            'user_id' => $user_id
        ];

        if ($file->move("public/uploads/event-files/", $newName)) {
            $this->eventfileModel->insert($data);
            if (isset($_POST['u'])) {
                return redirect()->to(HOST_URL . '/user/projects/event?p=' . $project_id . '&e=' . $event_id);
            } else {
                return redirect()->to(HOST_URL . '/admin/projects/event?p=' . $project_id . '&e=' . $event_id);
            }
        } else {
            echo "failed";
        }
    }

    public function eventsDelete()
    {

        $id = $_GET['e'];
        $pid = $_GET['p'];
        if (isset($_GET['filename'])) {
            $file_name = $_GET['filename'];
            $this->eventfileModel->where('file_name', $file_name)->delete();
            unlink('public/uploads/event-files/' . $file_name);
        }
        if (isset($_GET['u'])) {
            return redirect()->to(HOST_URL . '/user/projects/event?e=' . $id . '&p=' . $pid);
        } else {
            return redirect()->to(HOST_URL . '/admin/projects/event?e=' . $id . '&p=' . $pid);
        }
    }

    public function eventsDownload()
    {
        if (isset($_GET['filename'])) {
            $file_name = $_GET['filename'];
            $fileData = $this->eventfileModel->where('file_name', $file_name)->findAll();
            $document_name = $fileData[0]['document_name'];
            return $this->response->download('public/uploads/event-files/' . $file_name, null)->setFileName($document_name);
        }
    }


    public function meetings()
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

        $meetings = $this->meetingModel->findAll();

        $count = array();
        foreach ($meetings as $key => $meeting) {
            $meeting_id = $meeting['id'];
            $attendees = $this->attendanceModel->where("meeting_id", $meeting_id)->find();
            $attendeescount = count($attendees);
            array_push($count, $attendeescount);
        }
        $data = [
            'userData' => $userData,
            'meetings' => $meetings,
            'attendance' => $count
        ];

        return view('admin/meetings', $data);
    }

    public function meetingsAdd()
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

        $name = $_POST['agendaName'];
        $date = $_POST['agendaDate'];
        $hour = $_POST['hour'];
        $minute = $_POST['minute'];

        $tgl = substr($date, 0, 2);
        $bln = substr($date, 3, 2);
        $thn = substr($date, 6, 4);

        $datetime = $thn . '-' . $bln . '-' . $tgl . ' ' . $hour . ':' . $minute;

        $data = [
            'name' => $name,
            'datetime' => $datetime,
            'status' => 'closed'
        ];

        if ($this->meetingModel->insert($data)) {
            return redirect()->to(HOST_URL . '/admin/meetings');
        }
    }

    public function meetingsEdit()
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

        $name = $_POST['agendaName'];
        $date = $_POST['agendaDate'];
        $hour = $_POST['hour'];
        $minute = $_POST['minute'];
        $mid = $_POST['mid'];

        $tgl = substr($date, 0, 2);
        $bln = substr($date, 3, 2);
        $thn = substr($date, 6, 4);

        $datetime = $thn . '-' . $bln . '-' . $tgl . ' ' . $hour . ':' . $minute;

        $data = [
            'name' => $name,
            'datetime' => $datetime,
        ];

        if ($this->meetingModel->where('id', $mid)->set($data)->update()) {
            return redirect()->to(HOST_URL . '/admin/meetings');
        }
    }

    public function meetingsAttendance()
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

        $meeting_id = $_GET['m'];
        $attendance = $this->attendanceModel->where("meeting_id", $meeting_id)->find();

        $attendanceData = [];
        foreach ($attendance as $key => $participant) {
            $user_id = $participant['user_id'];

            $user = $this->userModel->where('id', $user_id)->find();
            $participantData = [
                $key => [
                    'id' => $user_id,
                    'name' => $user[0]['name'],
                    'nip' => $user[0]['nip'],
                    'nik' => $user[0]['nik'],
                    'position' => $user[0]['position'],
                    'instance' => $user[0]['instance'],
                    'email' => $user[0]['email'],
                    'signature' => $participant['signature'],
                    'meeting_id' => $participant['meeting_id'],
                ],
            ];
            $attendanceData = array_merge($attendanceData, $participantData);
        }
        $meetingData = $this->meetingModel->where('id', $meeting_id)->findAll();

        $data = [
            'userData' => $userData,
            'attendances' => $attendanceData,
            'meeting' => $meetingData
        ];

        return view('admin/attendance', $data);
    }

    public function meetingsAttopen()
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

        if (isset($_GET['m'])) {
            $mid = $_GET['m'];

            $this->meetingModel->where('id', $mid)->set('status', 'open')->update();
            return redirect()->to(HOST_URL . '/admin/meetings/attendance?m=' . $mid);
        } else {
            return redirect()->to(HOST_URL . '/admin/meetings');
        }
    }

    public function meetingsAttclose()
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

        if (isset($_GET['m'])) {
            $mid = $_GET['m'];
            $this->meetingModel->where('id', $mid)->set('status', 'closed')->update();
            return redirect()->to(HOST_URL . '/admin/meetings/attendance?m=' . $mid);
        } else {
            return redirect()->to(HOST_URL . '/admin/meetings');
        }
    }

    public function eventPurge()
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

        $event_id = $_POST['event_id'];
        $project_id = $_POST['project_id'];

        $files = $this->eventfileModel->where('event_id', $event_id)->find();

        foreach ($files as $key => $file) {
            $filename = $file['file_name'];
            unlink('public/uploads//event-files/' . $filename);
        }

        $this->eventfileModel->where('event_id', $event_id)->delete();
        if ($this->eventModel->where('id', $event_id)->delete()) {
            return "ok";
        } else {
            return "failed";
        }
    }

    public function meetingsDelete()
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

        $mid = $_POST['meeting_id'];

        if ($this->attendanceModel->where('meeting_id', $mid)->delete() &&  $this->meetingModel->where('id', $mid)->delete()) {
            return 'ok';
        } else {
            return 'failed';
        }
    }

    public function meetingsAttendance2pdf()
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

        $meeting_id = $_GET['m'];
        $attendance = $this->attendanceModel->where("meeting_id", $meeting_id)->find();

        $attendanceData = [];
        foreach ($attendance as $key => $participant) {
            $user_id = $participant['user_id'];

            $user = $this->userModel->where('id', $user_id)->find();
            $participantData = [
                $key => [
                    'id' => $user_id,
                    'name' => $user[0]['name'],
                    'nip' => $user[0]['nip'],
                    'nik' => $user[0]['nik'],
                    'position' => $user[0]['position'],
                    'instance' => $user[0]['instance'],
                    'email' => $user[0]['email'],
                    'signature' => $participant['signature'],
                    'meeting_id' => $participant['meeting_id'],
                ],
            ];
            $attendanceData = array_merge($attendanceData, $participantData);
        }
        $meetingData = $this->meetingModel->where('id', $meeting_id)->findAll();

        $data = [
            'attendances' => $attendanceData,
            'meeting' => $meetingData
        ];
        return view('admin/attendance2pdf', $data);
    }

    public function meetingsAttendance2xlsx()
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

        $meeting_id = $_GET['m'];
        $attendance = $this->attendanceModel->where("meeting_id", $meeting_id)->find();
        $meetingData = $this->meetingModel->where('id', $meeting_id)->findAll();

        $participantsList = [
            ['', 'Kegiatan', $meetingData[0]['name']],
            ['', 'Waktu Pelaksanaan', date_format(date_create($meetingData[0]['datetime']), "d-m-Y H:i A")],
            [],
            ['No', 'Nama Partisipan', 'NIP', 'NIK', 'Jabatan', 'Instansi']
        ];
        $no = 1;
        foreach ($attendance as $key => $participant) {
            $user_id = $participant['user_id'];

            $user = $this->userModel->where('id', $user_id)->find();
            $participantsList = array_merge(
                $participantsList,
                [
                    [
                        $no,
                        $user[0]['name'],
                        $user[0]['nip'],
                        $user[0]['nik'],
                        $user[0]['position'],
                        $user[0]['instance'],
                        // $participant['signature']
                    ]
                ]
            );
            $no++;
        }


        $xlsx = SimpleXLSXGen::fromArray($participantsList);
        $xlsx->downloadAs('Daftar Presensi ' . $meetingData[0]['name'] . '-' . $meetingData[0]['datetime'] . '.xlsx');
        exit;
    }
}
