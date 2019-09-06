<?php

/*
 * MyBB: Sharepoint8 - Admin CP
 *
 * Filename: Style PHP File
 *
 * Ported by: Vintagedaddyo
 *
 * MyBB Version: 1.8.x
 *
 * Style Version: 1.0
 * 
 */

// Disallow direct access to this file for security reasons

if(!defined("IN_MYBB"))
{
	die("Direct initialization of this file is not allowed.<br /><br />Please make sure IN_MYBB is defined.");
} 

class Page extends DefaultPage
{
	function generate_breadcrumb()
	{
		if(!is_array($this->breadcrumb_trail))
		{
			return false;
		}
		$trail = "";
		foreach($this->breadcrumb_trail as $key => $crumb)
		{
			if($this->breadcrumb_trail[$key+1])
			{
				$trail .= "<a href=\"".$crumb['url']."\">".$crumb['name']."</a>";
				if($this->breadcrumb_trail[$key+2])
				{
					$trail .= " &raquo; ";
				}
			}
			else
			{
				$trail .= " &raquo; <span class=\"active\">".$crumb['name']."</span>";
			}
		}
		return $trail;
	}


	function output_nav_tabs($tabs=array(), $active='')
	{
		global $plugins;
		$tabs = $plugins->run_hooks("admin_page_output_nav_tabs_start", $tabs);
		if(count($tabs) > 1)
		{
			$first = true;
			echo "<div class=\"nav_tabs\">";
			echo "\t<ul>\n";
			foreach($tabs as $id => $tab)
			{
				if($id == $active)
				{
					continue;
				}
				$class = '';
				if($tab['link_target'])
				{
					$target = " target=\"{$tab['link_target']}\"";
				}
				if($first) $class .= " first";
				echo "\t\t<li class=\"{$class}\"><a href=\"{$tab['link']}\"{$target}>{$tab['title']}</a></li>\n";
				$first = false;
				$target = '';
			}
			echo "\t</ul>\n";
			echo "</div>";
		}

		if($tabs[$active])
		{
			$intro_tab = $tabs[$active];
			echo "<div class=\"intro\">";
			echo "<h2>{$intro_tab['title']}</h2>";
			echo "<p>{$intro_tab['description']}</p>";
			echo "</div>";
		}
		$arguments = array('tabs' => $tabs, 'active' => $active);
		$plugins->run_hooks("admin_page_output_nav_tabs_end", $arguments);
	}


	/**
	 * Output the page footer.
	 */
	
	function output_footer($quit=true)
	{
		global $mybb, $maintimer, $db, $lang, $plugins;

		$args = array(
			'this' => &$this,
			'quit' => &$quit,
		);

		$plugins->run_hooks("admin_page_output_footer", $args);

		$memory_usage = get_friendly_size(get_memory_usage());

		$totaltime = format_time_duration($maintimer->stop());
		$querycount = $db->query_count;

		if(my_strpos(getenv("REQUEST_URI"), "?"))
		{
			$debuglink = htmlspecialchars_uni(getenv("REQUEST_URI")) . "&amp;debug=1#footer";
		}
		else
		{
			$debuglink = htmlspecialchars_uni(getenv("REQUEST_URI")) . "?debug=1#footer";
		}

		echo "			</div>\n";
		echo "		</div>\n";
		echo "	<br style=\"clear: both;\" />";
		echo "	<br style=\"clear: both;\" />";
		echo "	</div>\n";
		//echo "<div id=\"footer\"><p class=\"generation\">".$lang->sprintf($lang->generated_in, $totaltime, $debuglink, $querycount, $memory_usage)."</p><p class=\"powered\">Powered By <a href=\"http://www.mybb.com/\" target=\"_blank\">MyBB</a>, &copy; 2002-".COPY_YEAR." <a href=\"http://www.mybb.com/\" target=\"_blank\">MyBB Group</a>.</p></div>\n";
		echo "<div id=\"footer\"><p class=\"generation\">".$lang->sprintf($lang->generated_in, $totaltime, $debuglink, $querycount, $memory_usage)."</p><p class=\"powered\">Powered By <a href=\"http://www.mybb.com/\" target=\"_blank\">MyBB</a>, &copy; 2002-".COPY_YEAR." <a href=\"http://www.mybb.com/\" target=\"_blank\">MyBB Group</a> All Rights Reserved.&nbsp;&nbsp;Style \"Sharepoint8\" ported by <a href=\"http://vintagedaddyo.com/mybb/\" target=\"_blank\"><b>Vintagedaddyo</b></a>.</p></div>\n";
		if($mybb->debug_mode)
		{
			echo $db->explain;
		}
		echo "</div>\n";
		echo "</body>\n";
		echo "</html>\n";

		if($quit != false)
		{
			exit;
		}
	}
}

class SidebarItem extends DefaultSidebarItem
{
}

class PopupMenu extends DefaultPopupMenu
{
}

class Table extends DefaultTable
{
}

class Form extends DefaultForm
{
}

class FormContainer extends DefaultFormContainer
{
}
?>