<?php

class My_View_Helper_MyMenu extends Zend_View_Helper_Navigation_Menu
{
	/**
	 *
	 * @param Zend_Navigation_Container $container
	 * @return My_View_Helper_MyMenu
	 */
	public function myMenu(Zend_Navigation_Container $container = null)
	// -------------------------------------------------------------------------
	{
        return parent::menu($container);
	}

	/**
	 *
	 * @param Zend_Navigation_Page $page
	 * @return string - html
	 */
	public function htmlify(Zend_Navigation_Page $page)
	// -------------------------------------------------------------------------
	{
		if (preg_match('/norender/', $page->getClass()) > 0)
			return '';

		$icon = $page->get('icon');
		if ($icon !== null)
			$icon='<em class="icon-'.$icon.'"></em> ';
		else $icon='';

		// get label and title for translating
		$label = $page->getLabel();
		$title = $page->getTitle();

		$description = '';

		// translate label and title?
		if ($this->getUseTranslator() && $t = $this->getTranslator())
		{
			if (is_string($label) && !empty($label))
				$label = $t->translate($label);

			if (is_string($title) && !empty($title))
				$title = $t->translate($title);
		}

		// get attribs for element
		$attribs = array(
			'id'     => $page->getId(),
			'title'  => $title,
			'class'  => $page->getClass()
		);

		// Is page an infoHeader ?
		if ($page->getHref() == 'infoHeader')
		{
			$element = 'i';
		}
		// does page have an href?
		else if ($href = $page->getHref())
		{
			$element = 'a';
			$attribs['href'] = $href;
			$attribs['target'] = $page->getTarget();

			if (!empty($page->attr_rel))
				$attribs['rel'] = $page->attr_rel;

		} 
		else
		{
			$element = 'span';
		}

		if(!empty($page->description))
			$description = '<div class="description">' . $page->description . '</div>';

		if(!empty($page->max_lines))
			$attribs['rel'] = $page->max_lines;

		return '<' . $element . $this->_htmlAttribs($attribs) . '>' . $icon
			 //. $this->view->escape($label) . $description
			 . $label . $description
			 . '</' . $element . '>';
	}
}