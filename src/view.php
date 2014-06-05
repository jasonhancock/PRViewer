<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Open Pull Requests</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css">

        <style type="text/css">
            body {
                padding-top: 20px;
                padding-bottom: 20px;
            }

            .header,
            .footer {
                padding-right: 15px;
                padding-left: 15px;
            }

            .header h3 {
                padding-bottom: 19px;
                margin-top: 0;
                margin-bottom: 0;
                line-height: 40px;
            }

            .footer {
                padding-top: 19px;
                color: #777;
                font-size: .8em;
                text-align: right;
            }

            table {
                margin-top: 20px;
                margin-bottom: 20px;
                font-size: .9em;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="header">
                <h3 class="text-muted">Open Pull Requests</h3>
            </div>

            <table class="table table-striped">
                <tr>
                    <th>#</th>
                    <th>Repository</th>
                    <th>Description</th>
                    <th>Opened By</th>
                    <th>Created</th>
                    <th>Updated</th>
                </tr><?php
                foreach($pull_requests as $pr) {
                    printf('
                        <tr class="%s">
                            <td><a href="%s" target="_blank">%d</a></td>
                            <td><a href="%s" target="_blank">%s</a>/<a href="%s" target="_blank">%s</a></td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                        </tr>',
                        $pr['class'],
                        $pr['url'],
                        $pr['number'],
                        $pr['org_url'],
                        $pr['org'],
                        $pr['repo_url'],
                        $pr['repo'],
                        $pr['title'],
                        $pr['user'],
                        $pr['created_at'],
                        $pr['updated_at']
                    );
                }
                ?>
            </table>
            <?php if (isset($_GET['debug'])) { echo '<pre>'; print_r($pull_requests); echo '</pre>'; } ?>

            <div class="footer">
                <p>&copy; 2014 <a href="http://geek.jasonhancock.com">Jason Hancock</a></p>
            </div>
        </div>
    </body>
</html>
