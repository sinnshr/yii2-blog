<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * SignupForm is the model behind the signup form.
 *
 * @property-read User|null $user
 *
 */
class SignupForm extends Model
{
    public $username;
    public $password;
    public $email;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'string', 'max' => 255],
            ['username', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'username'],
            ['email', 'unique', 'targetClass' => User::class, 'targetAttribute' => 'email'],
            [['email'], 'email'],
            [['username', 'email', 'password'], 'required'],
        ];
    }

    /**
     * Signs up a user with the provided information.
     * @return bool whether the user is signed up successfully
     */
    public function signup()
    {
        if (!$this->validate()) {
            return false;
        }
        $user = new User();
        $user->username = $this->username;
        $user->setPassword($this->password);
        $user->email = $this->email;
        $user->generateAuthKey();

        if ($user->save()) {
            Yii::$app->authManager->assign(Yii::$app->authManager->getRole('author'), $user->id);
            return true;
        }
        var_dump($user->getErrors()); // <-- add this
        exit;

        return false;
    }

}
