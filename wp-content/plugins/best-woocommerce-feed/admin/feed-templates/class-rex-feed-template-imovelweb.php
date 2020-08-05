<?php

/**
 * The imovelweb Feed Template class.
 *
 * @link       https://rextheme.com
 * @since      1.1.4
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/
 */

/**
 *
 * Defines the attributes and template for imovelweb feed.
 *
 * @package    Rex_Product_Feed
 * @subpackage Rex_Product_Feed/admin/feed-templates/Rex_Feed_Template_Imovelweb
 * @author     RexTheme <info@rextheme.com>
 */
class Rex_Feed_Template_Imovelweb extends Rex_Feed_Abstract_Template {

    protected function init_atts(){
        $this->attributes = array(
            'Required Information' =>  array(
                'TituloImovel'         => 'TituloImovel',
                'CodigoImovel'         => 'CodigoImovel',
                'Observacao'           => 'Observacao',
                'AreaUtil'             => 'AreaUtil',
                'Bairro'               => 'Bairro',
                'Cidade'               => 'Cidade',
                'CodigoCentralVendas'  => 'CodigoCentralVendas',
                'Endereco'             => 'Endereco',
                'Modelo'               => 'Modelo',
                'QtdDormitorios'       => 'QtdDormitorios',
                'SubTipoImovel'        => 'SubTipoImovel',
                'TipoImovel'           => 'TipoImovel',
                'UF'                   => 'UF',
            ),

            'Optional Information' => array(
                'AreaTotal'             => 'AreaTotal',
                'CEP'                   => 'CEP',
                'Complemento'           => 'Complemento',
                'DivulgarEndereco'      => 'DivulgarEndereco',
                'Fotos'                 => 'Fotos',
                'IdadeImovel'           => 'IdadeImovel',
                'Latitude'              => 'Latitude',
                'Longitude'             => 'Longitude',
                'Numero'                => 'Numero',
                'PrecoCondominio'       => 'PrecoCondominio',
                'PrecoIptulmovel'       => 'PrecoIptulmovel',
                'PrecoLocacao'          => 'PrecoLocacao',
                'PrecoTemporada'        => 'PrecoTemporada',
                'PrecoVenda'            => 'PrecoVenda',
                'QtdBanheiros'          => 'QtdBanheiros',
                'QtdSuites'             => 'QtdSuites',
                'QtdVagas'              => 'QtdVagas',
                'Topografia'            => 'Topografia',
                'ToursVirtual360'       => 'ToursVirtual360',
                'UnidadeMetrica'        => 'UnidadeMetrica',
                'UrlAtendimentoOnline'  => 'UrlAtendimentoOnline',
                'Video'                 => 'Video',
                'VisualizarMapa'        => 'VisualizarMapa',
            ),

        );
    }

    protected function init_default_template_mappings(){
        $this->template_mappings = array(
            array(
                'attr'     => 'CodigoImovel',
                'type'     => 'meta',
                'meta_key' => 'id',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'TituloImovel',
                'type'     => 'meta',
                'meta_key' => 'title',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),

            array(
                'attr'     => 'Observacao',
                'type'     => 'meta',
                'meta_key' => 'description',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => '',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'AreaUtil',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Bairro',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Cidade',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'CodigoCentralVendas',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Endereco',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'Modelo',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'QtdDormitorios',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'SubTipoImovel',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'TipoImovel',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),
            array(
                'attr'     => 'UF',
                'type'     => 'static',
                'meta_key' => '',
                'st_value' => '',
                'prefix'   => '',
                'suffix'   => ' ',
                'escape'   => 'default',
                'limit'    => 0,
            ),

        );
    }

}
