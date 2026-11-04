<?php
/**
 * Sitemap 网站地图生成器
 * 生成网站地图，包含首页、已发布页面和已发布文章，方便搜索引擎抓取。
 * 修改自 hanny 版本，由 @白先生 部分优化重构，1.2.0 版优化了无效链接、重复链接和更新频率。
 *
 * @package Sitemap
 * @author 白先生
 * @version 1.2.0
 * @link https://www.baixiaomo360.com
 *
 */
class Sitemap_Plugin implements Typecho_Plugin_Interface
{
    /**
     * 激活插件方法,如果激活失败,直接抛出异常
     *
     * @access public
     * @return void
     * @throws Typecho_Plugin_Exception
     */
    public static function activate()
    {
		Helper::addRoute('sitemap', '/sitemap.xml', 'Sitemap_Action', 'action');
    }

    /**
     * 禁用插件方法,如果禁用失败,直接抛出异常
     *
     * @static
     * @access public
     * @return void
     */
    public static function deactivate()
	{
		Helper::removeRoute('sitemap');
	}

    /**
     * 获取插件配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form 配置面板
     * @return void
     */
    public static function config(Typecho_Widget_Helper_Form $form){}

    /**
     * 个人用户的配置面板
     *
     * @access public
     * @param Typecho_Widget_Helper_Form $form
     * @return void
     */
    public static function personalConfig(Typecho_Widget_Helper_Form $form){}

}
