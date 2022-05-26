<?php
namespace App\Model;

/**
 * DetailModel
 */
class TagModel
{
   /** @var \PDO $pdo PDOクラスインスタンス */
   private $pdo;

   /**
    * コンストラクタ
    *
    * @param \PDO $pdo \PDOクラスインスタンス
    */
   public function __construct($pdo)
   {
      // 引数に指定されたPDOクラスのインスタンスをプロパティに代入します。
      // クラスのインスタンスは別の変数に代入されても同じものとして扱われます。（複製されるわけではありません）
      $this->pdo = $pdo;
   }

   /**
    * レコードを取得するselect文
    * @return string レコードを取得するselect文
    */
   public function selectTag()
   {
      $sql = '';
      $sql .= 'SELECT';
      $sql .= ' t.id';
      $sql .= ' ,t.tag_name';
      $sql .= ' FROM tags as t';
      $sql .= ' LEFT JOIN users as u ON t.user_id = u.id';

      return $sql;
   }

   /**
    * 対象ユーザーのレコードを取得
    * @return array レコードの配列
    */
   public function getTag($user_id)
   {
      $this->checkId($user_id);

      $sql = "";
      // 登録済みのカラムをセレクトで取得
      $sql = $this->selectTag();
      $sql .= ' WHERE t.user_id = :user_id';
      $sql .= ' OR t.user_id = 0';
      $sql .= ' order by t.id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $user_id, \PDO::PARAM_INT);

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
      $sql .= 'INSERT into tags (';
      $sql .= ' user_id';
      $sql .= ' ,tag_name';
      $sql .= ') values (';
      $sql .= ' :user_id';
      $sql .= ' ,:tag_name';
      $sql .= ')';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_INT);
      $stmt->bindParam(':tag_name', $data['tag_name'], \PDO::PARAM_STR);
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
      $sql .= 'UPDATE tags set';
      $sql .= ' user_id = :user_id';
      $sql .= ' ,tag_name = :tag_name';
      $sql .= ' ,updated_at = CURRENT_TIMESTAMP';
      $sql .= ' WHERE id = :id';

      $stmt = $this->pdo->prepare($sql);
      $stmt->bindParam(':user_id', $data['user_id'], \PDO::PARAM_STR);
      $stmt->bindParam(':tag_name', $data['tag_name'], \PDO::PARAM_STR);
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
      $sql .= 'UPDATE tags set';
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
      $sql .= 'DELETE FROM tags';
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
