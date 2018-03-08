<?php
    DB::registerQuery('find_all_quotes', "select * from quotes order by createdAt desc");
    DB::registerQuery('find_quote', 'select * from quotes where id = :id');
    DB::registerQuery('add_quote', "insert into quotes (quote, source, author) values (:quote, :source, :author);");
?>