<?php
    DB::registerQuery('find_all_highlights', "select * from highlights order by createdAt desc");
    DB::registerQuery('find_highlight', 'select * from highlights where id = :id');
    DB::registerQuery('add_highlight', "insert into highlights (quote, source, author) values (:quote, :source, :author);");
?>