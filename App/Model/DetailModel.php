<?php
namespace App\Model;

/**
 * DetailModel
 */
class DetailModel
{
   /** @var \\PDO $pdo \PDOクラスインスタンス */
   private $pdo;

   /**
    * コンストラクタ
    *
    * @param \PDO $pdo \\PDOクラスインスタンス
    */
   public function __construct($pdo)
   {
      // 引数に指定された\PDOクラスのインスタンスをプロパティに代入します。
      // クラスのインスタンスは別の変数に代入されても同じものとして扱われます。（複製されるわけではありません）
      $this->pdo = $pdo;
   }

   /**
    * レコードを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectDetail()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' d.id';
      $sql .= ' ,d.item_id';
      $sql .= ' ,d.tag_id';
      $sql .= ' ,d.price';
      $sql .= ' ,d.memo';
      $sql .= ' ,d.is_recived';
      $sql .= ' ,t.tag_name';
      $sql .= ' FROM details as d';
      $sql .= ' LEFT JOIN items as i ON d.item_id = i.id';
      $sql .= ' LEFT JOIN tags as t ON d.tag_id = t.id';

      return $sql;
   }

   /**
    * item_idからレコードを取得
    * @return array レコードの配列
    */
   public function getDetailByItemIdNum($item_id, $page, $cnt)
   {
      $this->checkId($item_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectDetail();
      $sql .= ' WHERE d.item_id = :item_id';
      $sql .= ' AND d.deleted_at IS NULL';
      $sql .= " ORDER BY d.id LIMIT " . (($page - 1) * $cnt) . ", " . $cnt;

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':item_id', $item_id, \PDO::PARAM_INT);
      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * item_idからレコードを取得
    * @return array レコードの配列
    */
   public function getDetailByItemId($item_id)
   {
      $this->checkId($item_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectDetail();
      $sql .= ' WHERE d.item_id = :item_id';
      $sql .= ' AND d.deleted_at IS NULL';
      $sql .= ' order by d.id asc';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':item_id', $item_id, \PDO::PARAM_INT);

      $stmt->execute();
      $ret = $stmt->fetchAll(\PDO::FETCH_ASSOC);
      return $ret;
   }

   /**
    * 新規追加
    * @return array レコードの配列
    */
   public function insert($data)
   {
      // テーブルの構造でデフォルト値が設定されているカラムをinsert文で指定する必要はありません（特に理由がない限り）。
      $sql = '';
      $sql .= 'INSERT into details (';
      $sql .= ' item_id';
      $sql .= ' ,tag_id';
      $sql .= ' ,price';
      $sql .= ' ,memo';
      $sql .= ' ,is_recived';
      $sql .= ' ,deleted_at';
      $sql .= ') values (';
      $sql .= ' :item_id';
      $sql .= ' ,:tag_id';
      $sql .= ' ,:price';
      $sql .= ' ,:memo';
      $sql .= ' ,:is_recived';
      $sql .= ' ,NULL';
      $sql .= ')';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_INT);
      $stmt->bindParam(':tag_id', $data['tag_id'], \PDO::PARAM_INT);
      $stmt->bindParam(':price', $data['price'], \PDO::PARAM_STR);
      $stmt->bindParam(':memo', $data['memo'], \PDO::PARAM_STR);
      $stmt->bindParam(':is_recived', $data['is_recived'], \PDO::PARAM_STR);
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
      $sql .= 'UPDATE details set';
      $sql .= ' item_id = :item_id';
      $sql .= ' ,tag_id = :tag_id';
      $sql .= ' ,price = :price';
      $sql .= ' ,memo = :memo';
      $sql .= ' ,is_recived = :is_recived';
      $sql .= ' ,updated_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':item_id', $data['item_id'], \PDO::PARAM_STR);
      $stmt->bindParam(':tag_id', $data['tag_id'], \PDO::PARAM_STR);
      $stmt->bindParam(':price', $data['price'], \PDO::PARAM_STR);
      $stmt->bindParam(':memo', $data['memo'], \PDO::PARAM_STR);
      $stmt->bindParam(':is_recived', $data['is_recived'], \PDO::PARAM_STR);
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
   public function softDelete($id)
   {
      $this->checkId($id);

      $sql = '';
      $sql .= 'UPDATE details set';
      $sql .= ' deleted_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
      $ret = $stmt->execute();

      return $ret;
   }

   /**
    * 物理削除
    *
    * @param array $data 更新する作業項目の連想配列
    * @return bool 成功した場合:TRUE、失敗した場合:FALSE
    */
   public function hardDelete($id)
   {
      $this->checkId($id);

      $sql = '';
      $sql .= 'DELETE FROM details';
      $sql .= ' WHERE id = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
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
