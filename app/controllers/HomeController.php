<?php

namespace App\Controllers;

use Core\AController;
use App\Models\Operator;
use App\Models\CallLog;


class HomeController extends AController
{

    /**
     * render view
     */
    public function index()
    {
        $this->render('operators');
    }


    /**
     * echo data encoded with JSON
     */
    public function getOperatorsAJAX()
    {
        $operatorsModel = new Operator();
        $data = $operatorsModel->getAll();

        echo json_encode($data);
        exit;

    }

    /**
     * @param $data
     * redirect to main page
     */
    public function refreshLogs($data)
    {
        $operatorModel = new Operator();
        $callsLogsModel = new CallLog();

        $operatorInfo = $operatorModel->getOneByPhoneNumber($data['phoneNumber']);



        if (!isset($operatorInfo['id'])) {
            header('Location: /#wrong-phone-number');
            exit;
        }

        $data['phoneNumber'] = Operator::getNumberDigit($data['phoneNumber']);

        $apiController = new APIController();

        $result6 = $apiController->getCallsLogsForNumber($data, APIController::LOGS_HOURS_6);
        if (isset($result6['errorCode'])) {
            $this->result('', $result6);
        }

        $result24 = $apiController->getCallsLogsForNumber($data, APIController::LOGS_HOURS_24);
        if (isset($result24['errorCode'])) {
            $this->result('', $result24);
        }

        $result48 = $apiController->getCallsLogsForNumber($data, APIController::LOGS_HOURS_48);
        if (isset($result48['errorCode'])) {
            $this->result('', $result48);
        }


        $callsCount = [
            'calls_count_6h' => count($result6['records']),
            'calls_count_24h' => count($result24['records']),
            'calls_count_48h' => count($result48['records']),
            'last_call_date' => \App\Models\AModel::getDateDateTime($result48['records'][0]['startTime'])
        ];

        $operatorModel->editByID($operatorInfo['id'], $callsCount);

        if(count($result48['records']) > 0) {
            $callsLogsModel->deleteLogsByOperatorId($operatorInfo['id']);
            $insertedId = $callsLogsModel->insertOperatorLogs($operatorInfo['id'], $result48['records']);
            $this->result($insertedId . ' rows have been inserted into DB');
        } else {
            $this->result('Nothing has been inserted into DB');
        }

    }

    /**
     * @param string $message
     * @param array $result
     * Set Session message and redirect to home page
     */
    public function result($message, $result = [])
    {
        if (isset($result48['errorCode'])) {
            if ($result['errorCode'] == 'CMN-301') {
                $message = 'Request rate exceeded. Please, try again in 1 minute';
            } else {
                $message = 'Oops, something went wrong. Please, try again later';
            }
        }

        $_SESSION['api_info'] = $message;
        header('Location: /');
        exit;
    }

    /**
     * @param array $_POST $post
     * return operator's logs to Ajax
     */
    public function getAllLogsByOperatorIdAJAX($post)
    {
        $operatorId = (int)$post['operatorId'];
        $callLogModel = new CallLog();
        $logs = $callLogModel->getAllLogsByOperatorId($operatorId);
        echo json_encode($logs);
        exit;
    }

    /**
     * @param $post
     * return operator info to Ajax
     */
    public function getOperatorInfoByOperatorIdAJAX($post)
    {
        $operatorId = (int)$post['operatorId'];
        $operatorModel = new Operator();
        $operator = $operatorModel->getOneByID($operatorId);
        $operator['last_call_date'] = Operator::getFullDate($operator['last_call_date']);
        $operator['phone_number'] = Operator::formatPhoneNubmer($operator['phone_number']);
        $operator['operator_name'] = Operator::upperCaseStringWords($operator['operator_name']);
        $operator['last_call_date'] = Operator::getFullDate($operator['last_call_date']);

        echo json_encode($operator);
        exit;
    }

    /**
     * @param $post
     * return 1 if the record was edited
     */
    public function editOperatorInfoAJAX($post)
    {
        $operatorsModel = new Operator();
        $data = ($post['data']);
        $id = (int)$data['id'];
        unset($data['id']);

        $r = $operatorsModel->editOperatorByID($id, $data);

        echo json_encode($r);
        exit;
    }

}
