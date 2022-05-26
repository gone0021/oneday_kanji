<?php
namespace App\Model;

/**
 * ItemModel
 */
class ItemModel
{
   /** @var \\PDO $pdo PDOクラスインスタンス */
   private $pdo;

   /**
    * コンストラクタ
    *
    * @param \\PDO $pdo \PDOクラスインスタンス
    */
   public function __construct($pdo)
   {
      // 引数に指定されたPDOクラスのインスタンスをプロパティに代入します。
      // クラスのインスタンスは別の変数に代入されても同じものとして扱われます。（複製されるわけではありません）
      $this->pdo = $pdo;
   }

   /**
    * itemsの最後のidを取得
    * @return array レコードの配列
    */
   public function getNextId()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' MAX(id) as max_id';
      $sql .= ' FROM items';

      $stmt = $this->pdo->prepare($sql);
      $stmt->execute();
      $ret = $stmt->fetch(\PDO::FETCH_ASSOC);

      return (int)$ret['max_id'] + 1;
   }

   /**
    * レコードを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectItem()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' i.id';
      $sql .= ' ,i.user_id';
      $sql .= ' ,i.title';
      $sql .= ' ,i.date';
      $sql .= ' ,i.num';
      $sql .= ' ,i.budget';

      $sql .= ' FROM items as i';
      return $sql;
   }

   /**
    * 最大数を設定してレコードを取得：ページング用
    * @return array レコードの配列
    */
   public function getItemNum($user_id, $page, $cnt)
   {
      $this->checkId($user_id);

      $sql = '';
      $sql = $this->selectItem();
      $sql .= ' WHERE i.user_id = :user_id';
      $sql .= ' AND i.deleted_at IS NULL';
      $sql .= " ORDER BY i.id desc LIMIT " . (($page - 1) * $cnt) . ", " . $cnt;

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 対象ユーザーの全てのレコードを取得
    * @return array レコードの配列
    */
   public function getUserItem($user_id)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItem();
      $sql .= ' WHERE i.deleted_at IS NULL';
      $sql .= ' AND i.user_id = :user_id';
      $sql .= ' order by i.id desc';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);
      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }

   // 検索：search
   /**
    * タイトルまたは日付で検索
    * @return array レコードの配列
    */
   public function getSearchItemAll($user_id, $val)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItem();
      $sql .= ' WHERE i.deleted_at IS NULL';
      $sql .= ' AND i.user_id = :user_id';

      $sql .= ' AND (';
      $sql .= ' i.title LIKE :title';
      $sql .= ' OR i.date LIKE :date';
      $sql .= ' )';
      $sql .= ' order by i.date desc';

      $likeWord = "%$val%";

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);

      $stmt->bindParam(':title', $likeWord, \PDO::PARAM_STR);
      $stmt->bindParam(':date', $likeWord, \PDO::PARAM_STR);

      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 対象ユーザーのレコードを取得
    * @return array レコードの配列
    */
   public function getItemById($id)
   {
      $this->checkId($id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectItem();
      $sql .= ' WHERE i.deleted_at IS NULL ';
      $sql .= ' AND i.id = :id ';
      $sql .= ' order by i.id desc';

      // var_dump($sql);die;

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
      $stmt->execute();
      $ret = $stmt->fetch(\PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 新規追加
    * @return array レコードの配列
    */
   public function insert($data)
   {
      // echo '<pre>';
      // var_export($data);
      // echo '</pre>';

      // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
      $sql = '';
      $sql .= 'INSERT into items (';
      $sql .= ' user_id';
      $sql .= ' ,title';
      $sql .= ' ,date';
      $sql .= ' ,num';
      $sql .= ' ,budget';
      $sql .= ' ,deleted_at';
      $sql .= ') values (';
      $sql .= ' :user_id';
      $sql .= ' ,:title';
      $sql .= ' ,:date';
      $sql .= ' ,:num';
      $sql .= ' ,:budget';
      $sql .= ' ,NULL';
      $sql .= ')';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
      $stmt->bindParam(':title', $data['title'], \PDO::PARAM_STR);
      $stmt->bindParam(':date', $data['date'], \PDO::PARAM_STR);
      $stmt->bindParam(':num', $data['num'], \PDO::PARAM_STR);
      $stmt->bindParam(':budget', $data['budget'], \PDO::PARAM_STR);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 更新
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function update($data)
   {
      $this->checkId($data['id']);

      $sql = '';
      $sql .= 'UPDATE items set';
      $sql .= ' title = :title';
      $sql .= ' ,date = :date';
      $sql .= ' ,num = :num';
      $sql .= ' ,budget = :budget';
      $sql .= ' ,updated_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':title', $data['title'], \PDO::PARAM_STR);
      $stmt->bindParam(':date', $data['date'], \PDO::PARAM_STR);
      $stmt->bindParam(':num', $data['num'], \PDO::PARAM_STR);
      $stmt->bindParam(':budget', $data['budget'], \PDO::PARAM_STR);
      $stmt->bindParam(':id', $data['id'], \PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 論理削除
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function softDelete($data)
   {
      $this->checkId($data);

      $sql = '';
      $sql .= 'UPDATE items set';
      $sql .= ' deleted_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $data, \PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * IDの整合性チェック
    *
    * @return bool boool型
    */
   public function checkId($id)
   {
      // $data['id']が存在しなかったら、falseを返却
      if (!isset($id)) {
         return false;
      }

      // $idが数字でなかったら、falseを返却する。
      if (!is_numeric($id)) {
         return false;
      }

      // $idが0以下はありえないので、falseを返却
      if ($id <= 0) {
         return false;
      }
   }
}
