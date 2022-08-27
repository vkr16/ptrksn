<?php

namespace App\Controllers;

use CodeIgniter\Files\File;

class User extends BaseController
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
        helper('download');
    }

    public function index()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'admin') {
                return redirect()->to(HOST_URL . '/admin');
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

        return view('user/index', $data);
    }

    public function projectsDetail()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(HOST_URL . '/admin');
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
        return view('user/project-detail', $data);
    }

    public function projectsAddComment()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(HOST_URL . '/admin');
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
        return redirect()->to(HOST_URL . '/user/projects/detail?id=' . $project_id);
    }

    public function projectsUpload()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(HOST_URL . '/admin');
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
            return redirect()->to(HOST_URL . '/user/projects/detail?id=' . $project_id);
        } else {
            echo "failed";
        }
    }

    public function projectsDownload()
    {
        // Session Check
        if ($this->session->has('fw2_webclient_session')) {
            if ($this->session->get('fw2_webclient_role') == 'Admin') {
                return redirect()->to(HOST_URL . '/admin');
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
}
