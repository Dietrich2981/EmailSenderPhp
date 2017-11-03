<?php
require_once('class.db.php');

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10.05.2017
 * Time: 15:59
 */
class stats
{

    private function result($result_set)
    {
        $results = array();
        while (($row = $result_set->fetch_assoc()) != false) {
            $results[] = $row;
        }
        return $results;
    }

    private function getStats()
    {
        return $this->result(db::querydb("SELECT * FROM history ORDER BY id DESC LIMIT 5"));
    }

    public function showNews()
    {
        $stat = $this->getStats();
        for ($i = 0; $i < count($stat); $i++) {
            echo <<<HTML
    <div class="stat">
        <div class="col-lg-4">
            <div class="stat-cell">
                <table>
                    <tbody>
                    <tr>
                    <td>Тема</td>
                    <td class='separator'>:</td>
                    <td>{$stat[$i]['subject']}</td>
                    </tr>
                    <tr>
                    <td>Дата</td>
                    <td class='separator'>:</td>
                    <td>{$stat[$i]['data']}</td>
                    </tr>
                    <tr>
                    <td>Всего</td>
                    <td class='separator'>:</td>
                    <td>{$stat[$i]['all_mails']}</td>
                    </tr>
                    <tr>
                    <td>Успешно</td>
                    <td class='separator'>:</td>
                    <td>{$stat[$i]['success']}</td>
                    </tr>
                    <tr>
                    <td>Ошибка</td>
                    <td class='separator'>:</td>
                    <td>{$stat[$i]['error']}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-lg-8"><textarea name="text" id="h-message">{$stat[$i]['message']}</textarea></div>
    </div>
HTML;
        }
    }

}