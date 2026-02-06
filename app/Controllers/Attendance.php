<?php

namespace App\Controllers;

use App\Models\BeneficiaryAttendanceModel;
use App\Models\BeneficiaryModel;
use App\Models\EventModel;
use App\Models\ProjectModel;

class Attendance extends BaseController
{
    public function index()
    {
        $eventModel = new EventModel();

        $data = [
            'title'  => 'Events & Attendance',
            'events' => $eventModel
                ->select('events.*, projects.code as project_code')
                ->join('projects', 'projects.id = events.project_id', 'left')
                ->orderBy('event_date', 'DESC')
                ->findAll(),
        ];

        return view('attendance/index', $data);
    }

    public function createEvent()
    {
        $projectModel = new ProjectModel();

        $data = [
            'title'    => 'Create Event',
            'projects' => $projectModel->orderBy('code', 'ASC')->findAll(),
        ];

        return view('attendance/create_event', $data);
    }

    public function storeEvent()
    {
        $eventModel = new EventModel();

        $eventModel->insert([
            'project_id'  => $this->request->getPost('project_id') ?: null,
            'name'        => $this->request->getPost('name'),
            'type'        => $this->request->getPost('type'),
            'event_date'  => $this->request->getPost('event_date'),
            'location'    => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(site_url('attendance'))->with('message', 'Event created.');
    }

    public function editEvent($id)
    {
        $eventModel   = new EventModel();
        $projectModel = new ProjectModel();

        $event = $eventModel->find($id);
        if (! $event) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data = [
            'title'    => 'Edit Event',
            'event'    => $event,
            'projects' => $projectModel->orderBy('code', 'ASC')->findAll(),
        ];

        return view('attendance/edit_event', $data);
    }

    public function updateEvent($id)
    {
        $eventModel = new EventModel();

        $eventModel->update($id, [
            'project_id'  => $this->request->getPost('project_id') ?: null,
            'name'        => $this->request->getPost('name'),
            'type'        => $this->request->getPost('type'),
            'event_date'  => $this->request->getPost('event_date'),
            'location'    => $this->request->getPost('location'),
            'description' => $this->request->getPost('description'),
        ]);

        return redirect()->to(site_url('attendance'))->with('message', 'Event updated.');
    }

    public function deleteEvent($id)
    {
        $eventModel      = new EventModel();
        $attendanceModel = new BeneficiaryAttendanceModel();

        $attendanceModel->where('event_id', $id)->delete();
        $eventModel->delete($id);

        return redirect()->to(site_url('attendance'))->with('message', 'Event deleted.');
    }

    public function record($eventId)
    {
        $beneficiaryModel = new BeneficiaryModel();
        $eventModel       = new EventModel();
        $attendanceModel  = new BeneficiaryAttendanceModel();

        $event = $eventModel->find($eventId);

        $data = [
            'title'        => 'Record Attendance',
            'event'        => $event,
            'beneficiaries'=> $beneficiaryModel->orderBy('full_name', 'ASC')->findAll(),
            'existing'     => $attendanceModel->where('event_id', $eventId)->findAll(),
        ];

        return view('attendance/record', $data);
    }

    public function storeRecord($eventId)
    {
        $attendanceModel = new BeneficiaryAttendanceModel();
        $beneficiaries   = $this->request->getPost('beneficiaries') ?? [];

        foreach ($beneficiaries as $beneficiaryId => $status) {
            if ($status === '') {
                continue;
            }

            $existing = $attendanceModel
                ->where('event_id', $eventId)
                ->where('beneficiary_id', $beneficiaryId)
                ->first();

            $data = [
                'beneficiary_id' => $beneficiaryId,
                'event_id'       => $eventId,
                'status'         => $status,
            ];

            if ($existing) {
                $attendanceModel->update($existing['id'], $data);
            } else {
                $attendanceModel->insert($data);
            }
        }

        return redirect()->to(site_url('attendance'))->with('message', 'Attendance saved.');
    }
}
