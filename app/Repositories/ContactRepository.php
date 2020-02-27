<?php
/**
 * 账目联系人
 * User: Vera
 * Date: 2020/2/22
 * Time: 9:51
 */
namespace App\Repositories;

use App\Models\Contact;
use Carbon\Carbon;
use DB;

class ContactRepository
{
    public function exists($data)
    {
        return Contact::where($data)->exists();
    }

    public function get($id)
    {
        return Contact::find($id);
    }
    public function create($data)
    {
        return Contact::create($data);
    }

    public function delete($id)
    {
        return $this->get($id)->delete();
    }

    public function edit($id, $params)
    {
        $item = $this->get($id);
        if (!$item) {
            return false;
        }
		return $item->update($params);
    }

    public function builder($cond)
    {
        return Contact::where($cond);
    }

    /**
     * 获取拼音首字母
     */
    public function getPinYinLetter($str)
    {
        $sql = "select ELT(INTERVAL(CONV(HEX(left(CONVERT('".$str."' USING gbk),1)),16,10),
                    0xB0A1,0xB0C5,0xB2C1,0xB4EE,0xB6EA,0xB7A2,0xB8C1,0xB9FE,0xBBF7,
                    0xBFA6,0xC0AC,0xC2E8,0xC4C3,0xC5B6,0xC5BE,0xC6DA,0xC8BB,0xC8F6,
                    0xCBFA,0xCDDA,0xCEF4,0xD1B9,0xD4D1),
                    'A','B','C','D','E','F','G','H','J','K','L','M','N','O','P',
                    'Q','R','S','T','W','X','Y','Z') as letter";
        $letter = DB::select($sql);
        $first = $letter[0]->letter ? : strtoupper(substr($str, 0, 1));
        if (preg_match ("/^[A-Z]$/", $first)) {
            $first = "#";//非字母用#代替
        }
        return $first;
    }
    /**
     * 创建不存在的用户名称，存在则跳过
     * @param $data
     */
    public function createNotExists($data)
    {
        if (!$this->exists($data)) {
            //获取拼音首字母
            $name = $data['name'];
            $nameArr = mb_str_split($name,1);
            $letters = $firstLetter = "";
            foreach ($nameArr as $i => $item) {
                $letter = $this->getPinYinLetter($item);
                if ($i == 0) {
                    $firstLetter = $letter;
                }
                $letters .= $letter;
            }
            $data['first_letter'] = $firstLetter;
            $data['letters'] = $letters;
            return $this->create($data);
        }
        return false;
    }

    /**
     * 获取从A-Z的索引数据
     */
    public function getAZIndexList()
    {
        $contacts = $data = [];
        $items = Contact::orderBy("first_letter", "asc")->orderBy("letters", "asc")->get();
        //{"A":["abc","aaa"]}
        foreach ($items as $item) {
            $contacts[$item->first_letter][] = $item->name;
        }
        //[{"letter":"A","data":["abc","aaa"]}]
        foreach ($contacts as $firstLetter => $names) {
            $data[] = [
                "letter" => $firstLetter,
                "data" => $names
            ];
        }
        return $data;
    }
}