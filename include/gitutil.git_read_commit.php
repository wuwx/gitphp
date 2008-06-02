<?php
/*
 *  gitutil.git_read_commit.php
 *  gitphp: A PHP git repository browser
 *  Component: Git utility - read a commit
 *
 *  Copyright (C) 2008 Christopher Han <xiphux@gmail.com>
 */

 include_once('util.age_string.php');
 include_once('gitutil.git_rev_list.php');

function git_read_commit($proj,$head)
{
	$revlist = git_rev_list($proj,$head,1,TRUE,TRUE);
	$lines = explode("\n",$revlist);
	if (!($lines[0]) || !ereg("^[0-9a-fA-F]{40}",$lines[0]))
		return null;
	$commit = array();
	$tok = strtok($lines[0]," ");
	$commit['id'] = $tok;
	$tok = strtok(" ");
	$parents = array();
	while ($tok !== false) {
		$parents[] = $tok;
		$tok = strtok(" ");
	}
	$commit['parents'] = $parents;
	$commit['parent'] = $parents[0];
	$comment = array();
	foreach ($lines as $i => $line) {
		if (ereg("^tree ([0-9a-fA-F]{40})$",$line,$regs))
			$commit['tree'] = $regs[1];
		else if (ereg("^author (.*) ([0-9]+) (.*)$",$line,$regs)) {
			$commit['author'] = $regs[1];
			$commit['author_epoch'] = $regs[2];
			$commit['author_tz'] = $regs[3];
			if (ereg("^([^<]+) <",$commit['author'],$r))
				$commit['author_name'] = $r[1];
			else
				$commit['author_name'] = $commit['author'];
		} else if (ereg("^committer (.*) ([0-9]+) (.*)$",$line,$regs)) {
			$commit['committer'] = $regs[1];
			$commit['committer_epoch'] = $regs[2];
			$commit['committer_tz'] = $regs[3];
			$commit['committer_name'] = $commit['committer'];
			$commit['committer_name'] = ereg_replace(" <.*","",$commit['committer_name']);
		} else {
			$trimmed = trim($line);
			if ((strlen($trimmed) > 0) && !ereg("^[0-9a-fA-F]{40}",$trimmed) && !ereg("^parent [0-9a-fA-F]{40}",$trimmed)) {
				if (!isset($commit['title'])) {
					$commit['title'] = $trimmed;
					if (strlen($trimmed) > 50)
						$commit['title_short'] = substr($trimmed,0,50) . " ...";
					else
						$commit['title_short'] = $trimmed;
				}
				$comment[] = $trimmed;
			}
		}
	}
	$commit['comment'] = $comment;
	$age = time() - $commit['committer_epoch'];
	$commit['age'] = $age;
	$commit['age_string'] = age_string($age);
	if ($age > 60*60*24*7*2) {
		$commit['age_string_date'] = date("Y-m-d",$commit['committer_epoch']);
		$commit['age_string_age'] = $commit['age_string'];
	} else {
		$commit['age_string_date'] = $commit['age_string'];
		$commit['age_string_age'] = date("Y-m-d",$commit['committer_epoch']);
	}
	return $commit;
}

?>
