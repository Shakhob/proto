<?php


namespace common\components;

use Exception;
use kaabar\jwt\Jwt;
use Yii;
use yii\db\Query;
use yii\helpers\FileHelper;

class StaticFunctions
{
    public static function saveImage($image,$modelType,$modelId){
        $fileName = "photo" . md5($image->baseName . time() . rand(1,100000));
        $fileName .= "." . $image->extension;
        $dir = Yii::getAlias("@backend") . "/web/uploads/{$modelType}/{$modelId}/";
        if(!is_dir($dir)){
            FileHelper::createDirectory($dir);
        }
        if($image->saveAs($dir.$fileName)){
            return $fileName;
        }
    }
    public static function generateRandomPassword($length = 10) {
        // Символы, которые могут использоваться в пароле
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $password = '';

        // Выбираем случайные символы из строки $characters
        for ($i = 0; $i < $length; $i++) {
            $password .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $password;
    }
    public static function getImage($imageName,$modelType,$modelId)
    {
        $file = Yii::getAlias("@backend") . "/web/uploads/{$modelType}/{$modelId}/{$imageName}";
        if(is_file($file)){
            return Yii::$app->params['backend'] . "/uploads/{$modelType}/{$modelId}/{$imageName}";
        }
        return Yii::$app->params['backend'] . "/img/no_photo.png";
    }
    public static function deleteImage($model, $tableName,$fileName, $type = null)
    {
        switch ($type){
            case 'gallery':
                $file = Yii::getAlias('@backend') . "/web/uploads/{$tableName}/{$model->product_id}/{$fileName}";
                if (is_file($file)){
                    @unlink($file);
                }
                break;
            default:
                $file = Yii::getAlias('@backend') . "/web/uploads/{$tableName}/{$model}/{$fileName}";
                if (is_file($file)){
                    @unlink($file);
                }
                break;
        }
    }

    public static function getTableCounts($tableName)
    {
        $query = (new Query())
            ->from($tableName)
            ->count();

        return $query;
    }


    public static function debug($arr)
    {
        echo "<pre>" . print_r($arr, true) . "</pre>";
    }

    public static function formatPublishedDate($publishedDate)
    {
        $months = Yii::$app->params['months'];
        $englishMonth = Yii::$app->formatter->asDatetime($publishedDate, 'php:F');
        $russianMonth = isset($months[date('n', strtotime($publishedDate))]) ? $months[date('n', strtotime($publishedDate))] : $englishMonth;
        $formattedDate = Yii::$app->formatter->asDatetime($publishedDate, "php:d {$russianMonth} Y");
        $formattedDate = preg_replace('/(?<=\d)(st|nd|rd|th)\b/', '', $formattedDate);
        return $formattedDate;
    }

    public static function getUserByToken($token)
    {
        $key = bin2hex(random_bytes(16));
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));

            // $decoded теперь содержит расшифрованные данные из JWT токена
            print_r($decoded);
        } catch (Exception $e) {
            // В случае ошибки расшифровки или проверки подписи вы можете обработать исключение здесь
            echo 'Ошибка: ' . $e->getMessage();
        }
    }
}
