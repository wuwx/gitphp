{*
 *  header.tpl
 *  gitphp: A PHP git repository browser
 *  Component: Page header template
 *
 *  Copyright (C) 2006 Christopher Han <xiphux@gmail.com>
 *}
{* $contentType = strpos($_SERVER['HTTP_ACCEPT'], 'application/xhtml+xml') === false ? 'text/html' : 'application/xhtml+xml';
header("Content-Type: $contentType; charset=utf-8"); *}
<?xml version="1.0" encoding="utf-8"?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<!-- gitphp web interface {$version}, (C) 2006 Christopher Han <xiphux@gmail.com> -->
<head>
<title>{$title}</title>
{if $rss_link}
<link rel="alternate" title="{$project} log" href="{$SCRIPT_NAME}?p={$project}&a=rss" type="application/rss+xml" />
{/if}
<link rel="stylesheet" href="{$stylesheet}" type="text/css" />
{$smarty.capture.header}
</head>
<body>
<div class="page_header">
<a href="http://www.kernel.org/pub/software/scm/git/docs/" title="git documentation">
<img src="git-logo.png" width="72" height="27" alt="git" class="logo" />
</a>
<a href="index.php">projects</a> / 
{if $project}
  <a href="{$SCRIPT_NAME}?p={$project}&a=summary">{$project}</a>
  {if $action}
    / {$action}
  {/if}
  {if $enablesearch}
<form method="get" action="index.php" enctype="application/x-www-form-urlencoded">
<div class="search">
<input type="hidden" name="p" value="{$project}" />
<input type="hidden" name="a" value="search" />
<input type="hidden" name="h" value="{if $hash}{$hash}{else}HEAD{/if}" />
<select name="st">
<option {if $searchtype == 'commit'}selected="selected"{/if} value="commit">commit</option>
<option {if $searchtype == 'author'}selected="selected"{/if} value="author">author</option>
<option {if $searchtype == 'committer'}selected="selected"{/if} value="committer">committer</option>
</select> search: <input type="text" name="s" {if $search}value="{$search}"{/if} />
</div>
</form>
  {/if}
{/if}
</div>
