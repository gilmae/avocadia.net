<!DOCTYPE html>
<html>
    <head>
        <title>Highlights</title>
        <style>
            body {width:auto; margin:0 30% 0 2em; font-size:16px}
            h1 {font-size:1.2em; font-weight: normal; color:#666}
            form {width:auto; }
            fieldset {border:0;}
            form section {
                padding: 1em 2em;;
            }

            form label {
                margin-right:2em;
            }
            form textarea, form input {
                width:60%;
            }

            input[type=submit] {
                width:auto;
            }
        </style>
    </head>
    <body>
    <h1>Highlight</h1>
    <section>
        <article>
            <blockquote><?echo($model->quote)?></blockquote>
            <cite><? echo($model->author)?>, <? echo($model->source) ?>
            <footer>
                <ul>
                    <li>Recorded <? echo($model->createdAt)?></li>
                </ul>
            </footer>
        </article>
    </section>
</body>