<?php

/* NOTE: If there is documentation for a new extension, the extension's
   classes, enums and flags will need to be added to the $classes array
   before this search script will work with it!! */

/* set up the tools for the job - this array tests class and enum names
in order to capitalize them correctly, throughout the search routines */
$classes = array('GtkAccelGroup.', 'GtkAccelLabel.', 'GtkAdjustment.', 'GtkAlignment.', 'GtkArrow.', 'GtkAspectFrame.', 'GtkBin.', 'GtkBox.', 'GtkBoxChild.', 'GtkButton.', 'GtkButtonBox.', 'GtkCalendar.', 'GtkCheckButton.', 'GtkCheckMenuItem.', 'GtkCList.', 'GtkCListRow.', 'GtkColorSelection.', 'GtkColorSelectionDialog.', 'GtkCombo.', 'GtkContainer.', 'GtkCTree.', 'GtkCTreeNode.', 'GtkCurve.', 'GtkData.', 'GtkDialog.', 'GtkDrawingArea.', 'GtkEditable.', 'GtkEntry.', 'GtkEventBox.', 'GtkFileSelection.', 'GtkFixed.', 'GtkFixedChild.', 'GtkFontSelection.', 'GtkFontSelectionDialog.', 'GtkFrame.', 'GtkGammaCurve.', 'GtkHandleBox.', 'GtkHBox.', 'GtkHButtonBox.', 'GtkHPaned.', 'GtkHRuler.', 'GtkHScale.', 'GtkHScrollbar.', 'GtkHSeparator.', 'GtkImage.', 'GtkInputDialog.', 'GtkInvisible.', 'GtkItem.', 'GtkItemFactory.', 'GtkLabel.', 'GtkLayout.', 'GtkList.', 'GtkListItem.', 'GtkMenu.', 'GtkMenuBar.', 'GtkMenuItem.', 'GtkMenuShell.', 'GtkMisc.', 'GtkNotebook.', 'GtkObject.', 'GtkOptionMenu.', 'GtkPacker.', 'GtkPaned.', 'GtkPixmap.', 'GtkPlug.', 'GtkPreview.', 'GtkProgress.', 'GtkProgressbar.', 'GtkRadioButton.', 'GtkRadioMenuItem.', 'GtkRange.', 'GtkRuler.', 'GtkScale.', 'GtkScrollbar.', 'GtkScrolledWindow.', 'GtkSelectionData.', 'GtkSeparator.', 'GtkSocket.', 'GtkSpinButton.', 'GtkStatusBar.', 'GtkStyle.', 'GtkTable.', 'GtkTableChild.', 'GtkTearoffMenuItem.', 'GtkText.', 'GtkTipsQuery.', 'GtkToggleButton.', 'GtkToolBar.', 'GtkToolTips.', 'GtkTree.', 'GtkTreeItem.', 'GtkVBox.', 'GtkVButtonBox.', 'GtkViewport.', 'GtkVPaned.', 'GtkVRuler.', 'GtkVScale.', 'GtkVScrollbar.', 'GtkVSeparator.', 'GtkWidget.', 'GtkWindow.', 'GdkAtom.', 'GdkBitmap.', 'GdkColor.', 'GdkColormap.', 'GdkCursor.', 'GdkDragContext.', 'GdkEvent.', 'GdkEventAny.', 'GdkEventExpose.', 'GdkFont.', 'GdkGC.', 'GdkPixmap.', 'GdkVisual.', 'GdkWindow.', 'GdkCapStyle.', 'GdkCursorType.', 'GdkDragAction.', 'GdkEventMask.', 'GdkEventType.', 'GdkFill.', 'GdkFontType.', 'GdkFunction.', 'GdkInputCondition.', 'GdkJoinStyle.', 'GdkLineStyle.', 'GdkModifierType.', 'GdkRgbDither.', 'GdkSubwindowMode.', 'GdkVisualType.', 'GtkAccelFlags.', 'GtkAnchorType.', 'GtkArrowType.', 'GtkAttachOptions.', 'GtkButtonAction.', 'GtkButtonBoxStyle.', 'GtkCalendarDisplayOptions.', 'GtkCellType.', 'GtkCornerStyle.', 'GtkCTreeExpanderStyle.', 'GtkCTreeExpansionType.', 'GtkCTreeLineStyle.', 'GtkCurveType.', 'GtkDestDefaults.', 'GtkDirectionType.', 'GtkFontFilterType.', 'GtkFontType.', 'GtkJustification.', 'GtkObjectFlags.', 'GtkOrientation.', 'GtkPackerOptions.', 'GtkPackType.', 'GtkPolicyType.', 'GtkPositionType.', 'GtkPreviewType.', 'GtkProgressBarOrientation.', 'GtkProgressBarStyle.', 'GtkReliefStyle.', 'GtkResizeMode.', 'GtkScrollType.', 'GtkSelectionMode.', 'GtkShadowType.', 'GtkSideType.', 'GtkSortType.', 'GtkSpinButtonUpdatePolicy.', 'GtkSpinType.', 'GtkStateType.', 'GtkSubmenuPlacement.', 'GtkToolbarChildType.', 'GtkToolbarSpaceStyle.', 'GtkToolbarStyle.', 'GtkTreeViewMode.', 'GtkUpdateType.', 'GtkVisibility.', 'GtkWidgetFlags.', 'GtkWindowPosition.', 'GtkWindowType.', 'GtkScintilla.', 'GtkSQPane.', 'GladeXML.');

function tryprefix($lang, $func, $prefix) {
global $classes, $full_match;

$full_match = (int)0;
$types = array('method.', 'signal.', 'property.');
$hit = array();
$part = array();

/* get the 'ext' element of gtk/gdk filenames */
$first = substr($prefix, 0, 3);

/* get the 'ext' element of non-gtk/gdk filenames */
$ext = array();
$dir = opendir("$_SERVER[DOCUMENT_ROOT]/manual1/$lang");
while(($item = readdir($dir))!== false) {
	if(!is_dir($item)) {
		$part = explode('.', $item);
		if(strlen($part[0]) < 4 && $part[0] !== "gtk" && $part[0] !== "gdk" && !in_array($part[0], $ext)) 
			$ext[sizeof($ext)] = $part[0];
		}
	}
closedir($dir);

/* just so's we don't have to guess wildly at capitalisation in classes/enums */
for($i = 0; $i < sizeof($classes); $i++) {
	if(stristr($classes[$i], "${func}.")) $pos = $i;
	}
$realname = $classes[$pos];

/* check for classes, enums and static functions */
if(strstr($func, "gdk") || strstr($func, "gtk") || strstr($prefix, "method")) {
/* check for full gtk/gdk function name (e.g. 'gtkwindow::set_title') */
	if(strstr($prefix, "method") && strlen($prefix) > 11) {
		$try = "/manual1/${lang}/${first}.${prefix}${func}.php";
		if (file_exists("$_SERVER[DOCUMENT_ROOT]$try")) {
			$full_match++;
			$hit[] = $try;
			}
		else {
		/* check for the same under other extensions */
			foreach($ext as $first) {
				$try = "/manual1/${lang}/${first}.${prefix}${func}.php";
				if (file_exists("$_SERVER[DOCUMENT_ROOT]$try")) {
					$full_match++;
					$hit[] = $try;
					}
				}
			}
		}
		else {
/* check for a gtk/gdk static function, full class or enum name */
			$try = "/manual1/${lang}/${prefix}${func}.php";
			$constructor = "/manual1/${lang}/${prefix}${func}.constructor.php";
			if (file_exists("$_SERVER[DOCUMENT_ROOT]$constructor")) {
				$try = "/manual1/${lang}/${prefix}${realname}php";
				$constructor = "/manual1/${lang}/${prefix}${realname}constructor.php";
				$full_match = $full_match + 2;
				$hit = array($try, $constructor);
				}
			else if (file_exists("$_SERVER[DOCUMENT_ROOT]$try")) {
				$full_match++;
				$hit[] = $try;
				}
			else {
				$try = "/manual1/${lang}/${prefix}enum.${func}.php";
				if (file_exists("$_SERVER[DOCUMENT_ROOT]$try")) {
					$try = "/manual1/${lang}/${prefix}enum.${realname}php";
					$full_match++;
					$hit[] = $try;
					}
				}
			}
		}
	if(!$hit) {
	/* go through the extension classes */
		foreach($ext as $prefix) {
			$try = "/manual1/${lang}/${prefix}.${func}.php";
			$constructor = "/manual1/${lang}/${prefix}.${func}.constructor.php";
			if (file_exists("$_SERVER[DOCUMENT_ROOT]$constructor")) {
				$try = "/manual1/${lang}/${prefix}.${realname}php";
				$constructor = "/manual1/${lang}/${prefix}.${realname}constructor.php";
				$full_match = $full_match + 2;
				$hit = array($try, $constructor);
				}
			else if (file_exists("$_SERVER[DOCUMENT_ROOT]$try")) {
				$full_match++;
				$hit[] = $try;
				}
			else {
			/* cover against futureshock - non-g*k enums */
				$try = "/manual1/${lang}/${prefix}.enum.${func}.php";
				if (file_exists("$_SERVER[DOCUMENT_ROOT]$try")) {
					$try = "/manual1/${lang}/${prefix}.enum.${realname}php";
					$full_match++;
					$hit[] = $try;
					}
				}
			}
		}
	return $hit;
}

function wildcard($lang, $func, $hit) {
global $classes, $full_match;
	$full_match = (int)0;
	$dir = opendir("$_SERVER[DOCUMENT_ROOT]/manual1/$lang");
	while(($item = readdir($dir))!== false) {
		$part = explode('.', $item);
		$gtk = $part[0];
		$class = substr($part[1], 0, 3);
		$enum = substr($part[2], 0, 3);
		$method = substr($part[3], 0, 3);
		if($gtk == $class || $gtk == $enum || ($gtk !== "gtk" && $gtk !== "gdk")) {
			if(stristr($part[1], $func) || stristr($part[2], $func)) {
				if($part[2] !== "method" && $part[2] !== "property" 
						&& $part[2] !== "signal") {
				$try = "/manual1/${lang}/$item";
				if(file_exists("$_SERVER[DOCUMENT_ROOT]$try") &&
					!in_array($try, $hit)) {
					if(stristr($part[1], $func)) $uc = $part[1];
					else $uc = $part[2];
					for($i = 0; $i < sizeof($classes); $i++) {
						if(stristr($classes[$i], "$uc.")) $pos = $i;
					}
					$realname = $classes[$pos];
					if ($uc == $part[1]) {
						$try = "/manual1/${lang}/$part[0].$realname$part[2]";
						}
					else {
						$try = "/manual1/${lang}/$part[0].$part[1].$realname$part[3]";
						}
					similar_text(strtolower($func), strtolower($uc), $percent);
					if($percent == 100) $full_match++;
					if($percent > 50) $hit[] = $try;
					}
				}
			}
		}

		if($part[1] == "method") {
			if(strstr($part[2], $func)) {
				$try = "/manual1/${lang}/$item";
				if(file_exists("$_SERVER[DOCUMENT_ROOT]$try") && !in_array($try, $hit)) {
					similar_text(strtolower($func), strtolower($part[2]), $percent);
					if($percent == 100) $full_match++;
					if($percent > 50) $hit[] = $try;
				}
			}
		}

		if(($gtk == $class || ($gtk !== "gtk" && $gtk !== "gdk")) && strstr($part[3], $func)) {
			$try = "/manual1/${lang}/$item";
			if(file_exists("$_SERVER[DOCUMENT_ROOT]$try") && !in_array($try, $hit)) {
				for($i = 0; $i < sizeof($classes); $i++) {
					if(stristr($classes[$i], "$part[1].")) $pos = $i;
					}
				$realname = $classes[$pos];
				$try = "/manual1/${lang}/$part[0].$realname$part[2].$part[3].$part[4]";
				similar_text(strtolower($func), strtolower($part[3]), $percent);
				if($percent == 100) $full_match++;
				if($percent > 50) $hit[] = $try;
			}
		}
	}
	closedir($dir);
	return $hit;
}

function find_manual_page($lang, $function) {

	$tried = 0;
	$hit = array();

	/* fast track, single return :) */
	if(strstr($function, "::")) {
		list($funcpre, $funcpost) = split("::", $function);
		$try = tryprefix($lang, $funcpost, "$funcpre.method.");
		if($try) return $try;
	}
	elseif(strtolower(substr($function, 0, 3)) == "gtk" || 
	strtolower(substr($function, 0, 3 == "gdk"))) {
		$prefix = strtolower(substr($function, 0, 3));
		$try = tryprefix($lang, $function, "$prefix.");
		if($try) return $try;
	}
	else {
		/* if there's no :: or gtk in there we could be looking for anything */
		$try = wildcard($lang, $function, $hit);
		/* if($try) $result = array_merge($try, $result); */
		if ($try) return $try;
	}
	/*
	if($result) {
		return $result;
	}
	*/
	return "";
}

?>
