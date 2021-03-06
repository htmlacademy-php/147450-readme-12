<div class="container">
    <h1 class="page__title page__title--popular">Популярное</h1>
</div>
<div class="popular container">
    <div class="popular__filters-wrapper">
        <div class="popular__sorting sorting">
            <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
            <ul class="popular__sorting-list sorting__list">
                <li class="sorting__item sorting__item--popular">
                    <a class="sorting__link sorting__link--active" href="?sort_by=popularity">
                        <span>Популярность</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Лайки</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
                <li class="sorting__item">
                    <a class="sorting__link" href="#">
                        <span>Дата</span>
                        <svg class="sorting__icon" width="10" height="12">
                            <use xlink:href="#icon-sort"></use>
                        </svg>
                    </a>
                </li>
            </ul>
        </div>
        <div class="popular__filters filters">
            <b class="popular__filters-caption filters__caption">Тип контента:</b>
            <ul class="popular__filters-list filters__list">
                <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                    <!--Если параметра запроса не указано, то классом filters__button--active надо отметить ссылку «Все». -->
                    <a class="filters__button filters__button--ellipse filters__button--all <?= isFiltersButtonActive(
                        $typeIdFromQuery
                    ) ?>"
                       href="/">
                        <span>Все</span>
                    </a>
                </li>

                <?php
                foreach ($contentTypes as $type): ?>
                    <li class="popular__filters-item filters__item">
                        <!--1. Добавьте ссылкам внутри тега ul.popular__filters-list адрес,
                        ведущий на эту страницу с параметром запроса, в котором будет значение ID каждого из доступных типов контента.-->
                        <!--3. Если параметр запроса с типом контента существует, то необходимо для соответствующей ссылки из списка ul.popular__filters-list
                        добавить класс filters__button--active. -->
                        <a class="filters__button filters__button--<?= $type['type'] ?>
                            <?= isFiltersButtonActive($typeIdFromQuery, $type['id']) ?>"
                           href="?type_id=<?= $type['id'] ?>">
                            <span class="visually-hidden"><?= $type['name'] ?></span>
                            <svg class="filters__icon" width="22" height="18">
                                <use xlink:href="#icon-filter-<?= $type['type'] ?>"></use>
                            </svg>
                        </a>
                    </li>
                <?php
                endforeach; ?>
            </ul>
        </div>
    </div>
    <div class="popular__posts">
        <?php
        foreach ($posts as $postId => $post): ?>
            <article class="popular__post post post-<?= $post['type'] ?>">
                <header class="post__header">
                    <!-- Добавьте внутри заголовка каждой карточки постов ссылку на сценарий post.php
                    вместе с параметром запроса. В параметре запроса будет ID этого поста.-->
                    <h2><a href="/post.php?post_id=<?= $post['id'] ?>"><?= $post['title'] ?></a></h2>
                </header>
                <div class="post__main">
                    <!--содержимое для поста-цитаты-->
                    <?php
                    switch ($post['type']):
                        case 'quote': ?>
                            <blockquote>
                                <?= truncate($post['description']) ?>
                                <cite>Неизвестный Автор</cite>
                            </blockquote>

                            <?php
                            break;
                        case 'link': ?>
                            <!--содержимое для поста-ссылки-->
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="https://<?= $post['link_url'] ?>"
                                   title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="/img/favicons-link.png"
                                                 alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?= $post['title'] ?></h3>
                                        </div>
                                    </div>
                                    <span><?= $post['description'] ?></span>
                                </a>
                            </div>

                            <?php
                            break;
                        case 'photo': ?>
                            <!--содержимое для поста-фото-->
                            <div class="post-photo__image-wrapper">
                                <img src="img/<?= $post['image_url'] ?>" alt="Фото от пользователя" width="360"
                                     height="240">
                            </div>

                            <?php
                            break;
                        case 'video': ?>
                            <!--содержимое для поста-видео-->
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <?= embed_youtube_cover($post['description']) ?>
                                    <img src="img/coast-medium.jpg" alt="Превью к видео" width="360" height="188">
                                </div>
                                <a href="post-details.html" class="post-video__play-big button">
                                    <svg class="post-video__play-big-icon" width="14" height="14">
                                        <use xlink:href="#icon-video-play-big"></use>
                                    </svg>
                                    <span class="visually-hidden">Запустить проигрыватель</span>
                                </a>
                            </div>
                            <?php
                            break;
                        case 'text': ?>
                            <!--содержимое для поста-текста-->
                            <?= truncate($post['description']) ?>
                            <?php
                            break;
                    endswitch; ?>

                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="#" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <!--укажите путь к файлу аватара-->
                                    <img class="post__author-avatar" src="img/<?= $post['avatar'] ?>"
                                         alt="Аватар пользователя">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><?= $post['login'] ?></b>
                                    <time class="post__time" datetime="<?= $post['created_at'] ?>"
                                          title="<?= date('Y-m-d H:i', strtotime($post['created_at'])) ?>">
                                        <?= getDateDiff($post['created_at']) ?></time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                                         height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span><?= $post['views_number'] ?></span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#"
                                   title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </div>
            </article>
        <?php
        endforeach; ?>
    </div>
</div>

