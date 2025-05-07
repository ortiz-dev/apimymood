<?php
namespace Controllers;
use Core\Request;
use Services\DailyMoodService;

class DailyMoodController
{
    protected $request;
    protected $dailyMoodService;

    public function __construct()
    {
        $this->request = new Request();
        $this->dailyMoodService = new DailyMoodService();
    }

    public function registerDailyMood()
    {
        $data = json_decode($this->request->rawBody(), true);
        $this->dailyMoodService->register($data);
    }

    public function getSummaryWeek()
    {
        $this->dailyMoodService->getSummaryWeek();
    }
}