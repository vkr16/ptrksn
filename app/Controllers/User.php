<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

class User extends BaseController
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
    protected $tutorModel;

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
        $this->tutorModel = model('TutorModel', true, $db);
    }

    public function index()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
        }
        // Session Check End

        // On Session User Data
        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));


        $projects = $this->projectModel->findAll();

        $data = [
            'projects' => $projects,
            'userData' => $userData
        ];

        return view('user/index', $data);
    }

    public function projectsDetail()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
        }
        // Session Check End

        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));

        $id = $_GET['id'];


        $projectFiles = $this->projectfileModel->where('project_id', $id)->findAll();

        $arrayfiles = [];
        foreach ($projectFiles as $key => $file) {
            $user_id = $file['user_id'];
            $userUploaded = $this->userModel->where('id', $user_id)->find();
            if ($userUploaded[0]['role'] == 'Admin' || $userUploaded[0]['id'] == $userData['id']) {
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

        $events = $this->eventModel->where("project_id = $id")->find();
        $project = $this->projectModel->find($id);
        $data = [
            'project' => $project,
            'userData' => $userData,
            'commentData' => $arrayComments,
            'files' => $arrayfiles,
            'events' => $events

        ];
        return view('user/project-detail', $data);
    }

    public function projectsAddComment()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
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
        return redirect()->to(base_url() . '/user/projects/detail?id=' . $project_id);
    }

    public function projectsUpload()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
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
            return redirect()->to(base_url() . '/user/projects/detail?id=' . $project_id);
        } else {
            echo "failed";
        }
    }

    public function projectsDownload()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
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

    public function projectsEvent()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
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
                if ($userUploaded[0]['role'] == 'Admin' || $userUploaded[0]['id'] == $userData['id']) {

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
            }

            $data = [
                'event' => $event,
                'eventfiles' => $arrayfiles,
                'userData' => $userData
            ];

            return view('user/documents', $data);
        } else {
            return redirect()->to(base_url());
        }
    }

    public function meetings()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
        }
        // Session Check End

        // On Session User Data
        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));
        $meetings = $this->meetingModel->where('status', 'open')->find();
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

        return view('user/meetings', $data);
    }

    public function meetingsAttendance()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
        }
        // Session Check End

        // On Session User Data
        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));

        if (isset($_GET['m'])) {
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

            $user_id = $userData['id'];
            $attendStatus = $this->attendanceModel->where("meeting_id = $meeting_id AND user_id = $user_id")->find();
            if ($attendStatus != null) {
                $attendance = true;
            } else {
                $attendance = false;
            }
            $data = [
                'userData' => $userData,
                'attendances' => $attendanceData,
                'meeting' => $meetingData,
                'attendance' => $attendance

            ];

            return view('user/attendance', $data);
        } else {
            return redirect()->to(base_url() . '/user/meetings');
        }
    }

    public function meetingsSign()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
        }
        // Session Check End


        $signature = $_POST['signature'];
        $user = $_POST['user_id'];
        $meeting = $_POST['meeting_id'];
        $meetingData = $this->meetingModel->where('id', $meeting)->find();
        $data  = [
            'user_id' => $user,
            'meeting_id' => $meeting,
            'signature' => $signature
        ];
        if ($meetingData[0]['status'] == 'open') {
            if ($this->attendanceModel->insert($data)) {
                return "done";
            } else {
                return "failed";
            }
        } else {
            return "closed";
        }
    }

    public function meetingsVoid()
    {
        // Session Check
        if (!$this->session->has('fw2_webclient_session')) {
            return redirect()->to(base_url() . '/login');
        }
        // Session Check End


        $user = $_POST['user_id'];
        $meeting = $_POST['meeting_id'];

        if ($this->attendanceModel->where("user_id = $user AND meeting_id = $meeting")->delete()) {
            return "done";
        } else {
            return "failed";
        }
    }

    public function guide()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(base_url() . '/admin');
            }
        } else {
            return redirect()->to(base_url() . '/login');
        }
        // Session Check End

        // On Session User Data
        $userData = $this->userModel->find($this->session->get('fw2_webclient_session'));
        $userGuide  = $this->tutorModel->find(1);

        $data = [
            'userData' => $userData,
            'userGuide' => $userGuide['content']
        ];

        return view('user/guide', $data);
    }
}
