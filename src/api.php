<?php

require_once __DIR__ . '/../vendor/autoload.php';

$conf = include 'config.php';
date_default_timezone_set($conf['time_zone']);

$pull_requests = array();

foreach($conf['sites'] as $site) {
    $client = new \Github\Client();
    $client->setOption('base_url', $site['api_url']);
    $client->authenticate($site['token'], \Github\Client::AUTH_HTTP_TOKEN);

    $api_org = $client->api('organization');
    $api_pr = $client->api('pull_requests');

    foreach($site['organizations'] as $org_name) {
        $repos = $api_org->repositories($org_name);

        foreach($repos as $repo) {
            $repo_name = "$org_name/" . $repo['name'];
            if(in_array($repo_name, $site['exclude'])) {
                continue;
            }
            $pull_requests = array_merge(
                $pull_requests,
                process_repo($api_pr, $org_name, $repo['name'], 'open', $site['base_url'])
            );
        }
    }

    foreach($site['include'] as $repo_name) {
        $pieces = explode('/', $repo_name);
        $pull_requests = array_merge(
            $pull_requests,
            process_repo($api_pr, $pieces[0], $pieces[1], 'open', $site['base_url'])
        );
    }

    foreach($site['users'] as $user) {
        $repos = $client->api('user')->repositories($user);
        foreach($repos as $repo) {
            $repo_name = "$user/" . $repo['name'];
            if(in_array($repo_name, $site['exclude'])) {
                continue;
            }
            $pull_requests = array_merge(
                $pull_requests,
                process_repo($api_pr, $user, $repo['name'], 'open', $site['base_url'])
            );
        }
    }
}

usort($pull_requests, 'cmp');
$response = array(
    'pull_requests' => $pull_requests
);

if(isset($_GET['callback'])) {
    if($conf['jsonp_enabled']) {
        header('Content-Type: application/javascript');
        echo $_GET['callback'] . '(' . json_encode($response) . ');';

    } else {
        header('HTTP/1.0 403 Forbidden');
        echo 'JSONP disabled in configuration';
    }
} else {
    header('Content-Type: application/json');
    print json_encode($response);
}

function cmp ($a, $b) {
    return strcmp($a['created_at'], $b['created_at']);
}

function process_repo($api, $org_name, $repo_name, $state, $base_url) {
    $pull_requests = array();

    $prs = $api->all($org_name, $repo_name, 'open', 1, 500);
    foreach($prs as $pr) {
        $age = time() - strtotime($pr['created_at']);
        $pull_requests[] = array(
            'url' => $pr['html_url'],
            'created_at' => date('Y-m-d H:i:s', strtotime($pr['created_at'])),
            'updated_at' => date('Y-m-d H:i:s', strtotime($pr['updated_at'])),
            'org'        => $org_name,
            'org_url'    => $base_url . $org_name,
            'repo'       => $repo_name,
            'repo_url'   => $base_url . "$org_name/$repo_name",
            'user'       => $pr['user']['login'],
            'title'      => $pr['title'],
            'number'     => $pr['number'],
            'age'        => $age,
        );
    }

    return $pull_requests;
}
