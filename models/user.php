<?php
class User {
    public $id_user;
    public $usermail;
    public $password;
    public $userRole;
    public $adress;
    public $Nationalite;
    public $ddn;
    public $num;

    public function __construct($data) {
        $this->id_user = $data['id_user'] ?? null;
        $this->usermail = $data['usermail'] ?? '';
        $this->password = $data['password'] ?? '';
        $this->userRole = $data['userRole'] ?? '';
        $this->adress = $data['adress'] ?? '';
        $this->Nationalite = $data['Nationalite'] ?? '';
        $this->ddn = $data['ddn'] ?? '';
        $this->num = $data['num'] ?? '';
    }
}
