<?php
$pdo = new PDO("mysql:host=localhost;dbname=square", "root", "");
$posts = $pdo->query("SELECT img, title, reading_time, (
  SELECT COUNT(*) FROM comments WHERE comments.post_id = posts.id
) AS comments_count FROM posts ORDER BY id DESC"); // Je récupère la totalité des données de la table posts. Je fais une requête imbriquée qui me permet de récupérer tous les commentaires de la table comments en y incluant une condition: la valeur de post_id de la table comments soit égal à l'id de la table post.
$posts = $posts->fetchAll(PDO::FETCH_ASSOC); // Je récupère toutes les données sous forme d'un tableau associatif de la table posts.
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Square</title>
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  <link rel="stylesheet" href="dist/style.css" />
</head>

<body class="antialiased">
  <header class="bg-indigo-500 py-6 text-white">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
      <svg class="fill-current w-6 h-6" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M0 0h24v24H0z" fill-rule="evenodd" />
      </svg>
    </div>
  </header>
  <div class="md:container mx-auto md:px-6 lg:px-8 grid md:grid-cols-2 xl:grid-cols-3 gap-y-12 md:gap-x-8 pb-16 md:pt-16">
    <?php
    foreach ($posts as $post) : ?>
      <article>
        <img src="img/<?= $post["img"] ?>" alt="<?= $post["img"] ?>" class="w-full" />
        <div class="px-4 sm:px-6 md:px-0">
          <h1 class="mt-4 text-2xl sm:text-3xl md:text-2xl font-bold text-gray-900">
            <?= $post["title"] ?>
          </h1>
          <ul class="mt-6 flex space-x-8 font-bold text-sm text-gray-700">
            <li class="flex items-center leading-none">
              <svg class="stroke-current w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <span class="mb-px ml-1"><?= $post["comments_count"] ?></span>
            </li>
            <li class="flex items-center leading-none">
              <svg class="stroke-current w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <span class="mb-px ml-1"><?= $post["reading_time"] ?> minutes</span>
            </li>
          </ul>
        </div>
      </article>
    <?php endforeach; ?>
  </div>
</body>

</html>