<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 2/3/2015
 * Time: 9:37 AM
 */
namespace c006\alerts;

use c006\alerts\assets\AppAssets;
use Yii;
use yii\bootstrap\Widget;

/**
 * Class Alerts
 *
 * @package c006\alerts
 */
class Alerts extends Widget
{

    const ALERT_DANGER  = 'alert-danger';
    const ALERT_WARNING = 'alert-warning';
    const ALERT_INFO    = 'alert-info';
    const ALERT_SUCCESS = 'alert-success';

    /** @var  $id string */
    public $id;

    /** @var  $message string */
    public $message;

    /** @var  $alert_type string
     *
     * Use constants
     */
    public $alert_type;

    /** @var  $close boolean */
    public $close = TRUE;

    /** @var  $countdown int */
    public $countdown;

    /**
     * @param $message
     */
    static public function setMessage($message)
    {
        Yii::$app->session->set('C006_ALERT', $message);
    }

    /**
     * @param $alert_type
     */
    static public function setAlertType($alert_type)
    {
        Yii::$app->session->set('C006_ALERT_TYPE', $alert_type);
    }

    /**
     * Add css
     */
    function init()
    {
        parent::init();
        $view = $this->getView();
        AppAssets::register($view);
    }

    function run()
    {
        $this->id   = "ALERT-" . time();
        $message    = ($this->message) ? $this->message : Alerts::getMessage();
        $alert_type = ($this->alert_type) ? $this->alert_type : Alerts::getAlertType();
        if (!$alert_type) {
            $alert_type = Alerts::ALERT_INFO;
        }
        if ($message) {
            /* Clears message after use */
            Alerts::clearMessage();

            return $this->render('alerts',
                                 [
                                     'id'         => $this->id,
                                     'message'    => $message,
                                     'alert_type' => $alert_type,
                                     'close'      => $this->close,
                                     'countdown'  => $this->countdown,
                                 ]);
        }

        return FALSE;
    }

    /**
     * @return mixed
     */
    static public function getMessage()
    {
        return Yii::$app->session->get('C006_ALERT');
    }

    /**
     * @return mixed
     */
    static public function getAlertType()
    {
        return Yii::$app->session->get('C006_ALERT_TYPE');
    }

    /**
     * Clears stored message
     */
    static public function clearMessage()
    {
        Yii::$app->session->set('C006_ALERT', NULL);
    }

}
