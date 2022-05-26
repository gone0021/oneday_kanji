<nav class="navbar navbar-expand-lg navbar-light">
   <a class="navbar-brand ml-5" href="<?= $url ?>/kanji">HOME</a>

   <!-- ハンバーガーメニュー -->
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
   </button>

   <!-- ナビバー -->
   <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
         <?php if (empty($user)) : ?>
            <li class="nav-item">
               <a class="nav-link" href="<?= $url ?>/auth/login/">login</a>
            </li>
            <li class="nav-item">
               <a class="nav-link" href="<?= $url ?>/auth/register/">register</a>
            </li>
         <?php endif; ?>

         <?php if (!empty($user)) : ?>
            <li class="nav-item dropdown">
               <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  user：<?= $user['user_name'] ?>
               </a>
               <div class="dropdown-menu" ria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="<?= $url ?>/kanji/user/">ユーザー設定</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?= $url ?>/kanji/tag/">タグ設定</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="<?= $url ?>/kanji/logout.php">ログアウト</a>
               </div>
            </li>
         <?php endif; ?>
      </ul>
   </div>
</nav>