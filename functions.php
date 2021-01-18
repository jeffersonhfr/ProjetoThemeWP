<?php

function carrega_scripts()
{
    // Registrar Plugin
    wp_register_script('plugins', get_template_directory_uri() . '/js/plugins.js', array(), false, true);

    /* O segundo argumento TRUE significa que o script irá carregar no footer, caso deseje carregar no HEAD deixar FALSE o segundo argumento */

    // Registrar Script
    wp_register_script('scripts', get_template_directory_uri() . '/js/main-min.js', array(), false, true);

    wp_enqueue_script(['plugins', 'scripts']);
}

add_action('wp_enqueue_scripts', 'carrega_scripts');


function carrega_css()
{
    // Registrar Style
    wp_register_style('style', get_template_directory_uri() . '/style.css', array(), false, false);

     /* O segundo argumento TRUE significa que o script irá carregar no footer, caso deseje carregar no HEAD deixar FALSE o segundo argumento */
     
    // Registrar Style-Add
    wp_register_style('style-add', get_template_directory_uri() . '/css/style-add.css', array(), false, false);


    wp_enqueue_style(['style', 'style-add']);
}

add_action('wp_enqueue_scripts', 'carrega_css');


// Funções para Limpar o Header
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('admin_print_scripts', 'print_emoji_detection_script');
remove_action('wp_print_styles', 'print_emoji_styles');
remove_action('admin_print_styles', 'print_emoji_styles');

// Habilitar Menus
add_theme_support('menus');

// Registrar Menu
function register_my_menu()
{
    register_nav_menu('menu-principal', __('Menu Principal'));
}
add_action('init', 'register_my_menu');


// Custom Images Sizes
function my_custom_sizes()
{
    add_image_size('large', 1400, 380, true);
    add_image_size('medium', 768, 380, true);
}
add_action('after_setup_theme', 'my_custom_sizes');


// Exit if accessed directly.
defined('ABSPATH') || exit;

function remove_menus()
{
    //remove_menu_page('index.php');                  //Dashboard  
    //remove_menu_page('edit.php');                   //Posts  
    //remove_menu_page( 'upload.php' );             //Media  
    //remove_menu_page('edit.php?post_type=page');    //Pages  
    //remove_menu_page('edit-comments.php');          //Comments  
    //remove_menu_page('themes.php');                 //Appearance  
    //remove_menu_page('plugins.php');                //Plugins  
    //remove_menu_page('users.php');              //Users  
    //remove_menu_page('tools.php');                  //Tools  
    //remove_menu_page('options-general.php');        //Settings  
}
add_action('admin_menu', 'remove_menus');


/* Remove Contact Form 7 Links from dashboard menu items if not admin */
if (!(current_user_can('administrator'))) {
    /*if (!(current_user_can(''))) {*/
    function remove_wpcf7()
    {
        remove_menu_page('wpcf7');
    }

    add_action('admin_menu', 'remove_wpcf7');
}



/**
 * INICIO  CUSTOMIZAÇÃO


function registrando_post_customizado_customizacao()
{
    register_post_type(
        'customizacao',
        array(
            'labels' => array('name' => 'Customização'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-email-alt',
            'supports' => array(
                'title',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_customizacao');

function registrando_meta_box_customizacao()
{
    add_meta_box(
        'ai_registrando_metabox',
        '--Customização--',
        'customizacao_callback',
        'customizacao',
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_customizacao');

function customizacao_callback($post)
{
    $customizacao_logodesk = get_post_meta($post->ID, '_customizacao_logodesk', true);
    $customizacao_logomob = get_post_meta($post->ID, '_customizacao_logomob', true);
    $customizacao_telefone = get_post_meta($post->ID, '_customizacao_telefone', true);
    $customizacao_email = get_post_meta($post->ID, '_customizacao_email', true);
    $customizacao_linkedin = get_post_meta($post->ID, '_customizacao_linkedin', true);
    $customizacao_instagram = get_post_meta($post->ID, '_customizacao_instagram', true);
    $customizacao_facebook = get_post_meta($post->ID, '_customizacao_facebook', true);
?>
    <label for="customizacao_logodesk">URL Logo - Desktop</label>
    <input type="text" name="customizacao_logodesk" placeholder='http://...' style="width: 100%" value="<?= $customizacao_logodesk ?>" />
    <br>
    <br>
    <label for="customizacao_logomob">URL Logo - Mobile</label>
    <input type="text" name="customizacao_logomob" placeholder="http://..." style="width: 100%" value="<?= $customizacao_logomob ?>" />
    <br>
    <br>
    <label for="customizacao_telefone">Número de Telefone</label>
    <input type="text" name="customizacao_telefone" placeholder="+55 11 0000 0000" style="width: 100%" value="<?= $customizacao_telefone ?>" />
    <label for="customizacao_email">E-mail Everest</label>
    <input type="text" name="customizacao_email" placeholder='contato@everest.com.br' style="width: 100%" value="<?= $customizacao_email ?>" />
    <br>
    <br>
    <label for="customizacao_linkedin">URL Linkedin</label>
    <input type="text" name="customizacao_linkedin" placeholder="http://..." style="width: 100%" value="<?= $customizacao_linkedin ?>" />
    <br>
    <br>
    <label for="customizacao_instagram">URL Instagram</label>
    <input type="text" name="customizacao_instagram" placeholder="http://..." style="width: 100%" value="<?= $customizacao_instagram ?>" />
    <br>
    <br>
    <label for="customizacao_facebook">URL Página do Facebook</label>
    <input type="text" name="customizacao_facebook" placeholder="http://..." style="width: 100%" value="<?= $customizacao_facebook ?>" />
<?php
}

function salvando_dados_metabox_customizacao($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'customizacao_logodesk' && $key !== 'customizacao_logomob' && $key !== 'customizacao_telefone' && $key !== 'customizacao_email' && $key !== 'customizacao_linkedin' && $key !== 'customizacao_instagram' && $key !== 'customizacao_facebook') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_customizacao');


 * FINAL  CUSTOMIZAÇÃO
 */


/**
 * INICIO SLIDER
 

function registrando_post_customizado_sliders()
{
    register_post_type(
        'sliders',
        array(
            'labels' => array('name' => 'Slider'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-format-image',
            'supports' => array(
                'title',
                'thumbnail',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_sliders');

function registrando_meta_box_sliders()
{
    add_meta_box(
        'ai_registrando_metabox',
        '-- Slider --',
        'sliders_callback',
        'sliders'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_sliders');

function sliders_callback($post)
{

    $slider_titulo = get_post_meta($post->ID, '_slider_titulo', true);
    $slider_texto = get_post_meta($post->ID, '_slider_texto', true);
    $slider_link = get_post_meta($post->ID, '_slider_link', true);
    $slider_cor = get_post_meta($post->ID, '_slider_cor', true);
?>
    <label for="slider_titulo">Título</label>
    <input type="text" name="slider_titulo" placeholder='A campanha está no ar!' style="width: 100%" value="<?= $slider_titulo ?>" />
    <br>
    <br>
    <label for="slider_texto">Texto</label>
    <input type="text" name="slider_texto" placeholder="Campanha on-line de captação de recursos para a Associação Cuidado Humano está no ar!" style="width: 100%" value="<?= $slider_texto ?>" />
    <br>
    <br>
    <label for="slider_link">Link</label>
    <input type="text" name="slider_link" placeholder="http://wwww.example.com.br" style="width: 100%" value="<?= $slider_link ?>" />
    <br>
    <br>
    <label for="slider_cor">Cor (Hexadecimal ou Nome em Inglês)</label>
    <input type="text" name="slider_cor" placeholder="#cc0000 ou red" style="width: 100%" value="<?= $slider_cor ?>" />
<?php
}

function salvando_dados_metabox_sliders($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'slider_titulo' && $key !== 'slider_texto' && $key !== 'slider_link' && $key !== 'slider_cor') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_sliders');

/**
 * FINAL SLIDER
 */




/**
 * INICIO SOBRE


function registrando_post_customizado_sobre()
{
    register_post_type(
        'sobre',
        array(
            'labels' => array('name' => 'Empresa'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-store',
            'supports' => array(
                'title',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_sobre');

function registrando_meta_box_sobre()
{
    add_meta_box(
        'ai_registrando_metabox',
        '-- Sobre --',
        'sobre_callback',
        'sobre'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_sobre');

function sobre_callback($post)
{

    $sobre_empresa = get_post_meta($post->ID, '_sobre_empresa', true);
    $sobre_missao = get_post_meta($post->ID, '_sobre_missao', true);
    $sobre_visao = get_post_meta($post->ID, '_sobre_visao', true);
    $sobre_valores = get_post_meta($post->ID, '_sobre_valores', true);
?>
    <label for="sobre_empresa">Texto Sobre</label>
    <input type="text" name="sobre_empresa" placeholder='A <strong>Everest</strong> é uma empresa especializada e dedicada para o ' style="width: 100%" value="<?= $sobre_empresa ?>" />
    <br>
    <span>Para inserir negrito, basta adicionar a palavra em negrito entre as tags strong </span>
    <br>
    <br>
    <br>
    <label for="sobre_missao">Misão</label>
    <input type="text" name="sobre_missao" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit." style="width: 100%" value="<?= $sobre_missao ?>" />
    <br>
    <br>
    <label for="sobre_visao">Visão</label>
    <input type="text" name="sobre_visao" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit." style="width: 100%" value="<?= $sobre_visao ?>" />
    <br>
    <br>
    <label for="sobre_valores">Valores</label>
    <input type="text" name="sobre_valores" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit." style="width: 100%" value="<?= $sobre_valores ?>" />
<?php
}

function salvando_dados_metabox_sobre($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'sobre_empresa' && $key !== 'sobre_missao' && $key !== 'sobre_visao' && $key !== 'sobre_valores') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_sobre');

/**
 * FINAL SOBRE
 */



/**
 * INICIO ESPECIALIDADES


function registrando_post_customizado_especialidades()
{
    register_post_type(
        'especialidades',
        array(
            'labels' => array('name' => 'Especialidades'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-star-filled',
            'supports' => array(
                'title',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_especialidades');

function registrando_meta_box_especialidades()
{
    add_meta_box(
        'ai_registrando_metabox',
        '-- Especialidades --',
        'especialidades_callback',
        'especialidades'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_especialidades');

function especialidades_callback($post)
{

    $especialidade_titulo = get_post_meta($post->ID, '_especialidade_titulo', true);
    $especialidade_texto = get_post_meta($post->ID, '_especialidade_texto', true);

?>
    <label for="especialidade_titulo">Titulo Especialidade</label>
    <input type="text" name="especialidade_titulo" placeholder='Lorem ipsum dolor sit amet, consectetur adipiscing elit....' style="width: 100%" value="<?= $especialidade_titulo ?>" />
    <br>
    <br>
    <label for="especialidade_texto">Texto Descrição</label>
    <input type="text" name="especialidade_texto" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ut nibh euismod, vulputate eros cursus, rhoncus nisi. Aliquam porttitor nunc at commodo pretium. In interdum imperdiet ultricies. Donec viverra vehicula ante in lobortis. Nulla non ex nec metus fringilla vehicula eget mattis magna. Proin a felis dui. Ut dictum est sit amet odio vehicula, et ullamcorper est mollis. Integer vulputate lacinia viverra. Fusce consequat orci augue, in sollicitudin nisl tincidunt non. Proin molestie diam sed auctor interdum." style="width: 100%" value="<?= $especialidade_texto ?>" />

<?php
}

function salvando_dados_metabox_especialidades($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'especialidade_titulo' && $key !== 'especialidade_texto' && $key !== 'especialidade_cor') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_especialidades');

/**
 * FINAL ESPECIALIDADES
 */




/**
 * INICIO SERVIÇOS

function registrando_post_customizado_servicos()
{
    register_post_type(
        'servicos',
        array(
            'labels' => array('name' => 'Serviços'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-clipboard',
            'supports' => array(
                'title',
                'thumbnail',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_servicos');

function registrando_meta_box_servicos()
{
    add_meta_box(
        'ai_registrando_metabox',
        '-- Serviços --',
        'servicos_callback',
        'servicos'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_servicos');

function servicos_callback($post)
{

    $servico_icon = get_post_meta($post->ID, '_servico_icon', true);
    $servico_resumo = get_post_meta($post->ID, '_servico_resumo', true);
    $servico_completo = get_post_meta($post->ID, '_servico_completo', true);
    $servico_cor = get_post_meta($post->ID, '_servico_cor', true);
?>
    <label for="servico_icon">URL Icone</label>
    <input type="text" name="servico_icon" placeholder='http://www...' style="width: 100%" value="<?= $servico_icon ?>" />
    <br>
    <br>
    <label for="servico_resumo">Texto do Serviço - Resumo</label>
    <input type="text" name="servico_resumo" placeholder='Lorem ipsum dolor sit amet, consectetur adipiscing elit....' style="width: 100%" value="<?= $servico_resumo ?>" />
    <br>
    <br>
    <label for="servico_completo">Texto do Serviço - Completo</label>
    <input type="text" name="servico_completo" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ut nibh euismod, vulputate eros cursus, rhoncus nisi. Aliquam porttitor nunc at commodo pretium. In interdum imperdiet ultricies. Donec viverra vehicula ante in lobortis. Nulla non ex nec metus fringilla vehicula eget mattis magna. Proin a felis dui. Ut dictum est sit amet odio vehicula, et ullamcorper est mollis. Integer vulputate lacinia viverra. Fusce consequat orci augue, in sollicitudin nisl tincidunt non. Proin molestie diam sed auctor interdum." style="width: 100%" value="<?= $servico_completo ?>" />
    <br>
    <br>
    <label for="servico_cor">Cor da Aba</label>
    <input type="text" name="servico_cor" placeholder="#cc0000" style="width: 100%" value="<?= $servico_cor ?>" />
<?php
}

function salvando_dados_metabox_servicos($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'servico_icon' && $key !== 'servico_titulo' && $key !== 'servico_resumo' && $key !== 'servico_completo' && $key !== 'servico_cor') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_servicos');

/**
 * FINAL SERVIÇOS
 */



/**
 * INICIO DEPOIMENTO


function registrando_post_customizado_depoimento()
{
    register_post_type(
        'depoimento',
        array(
            'labels' => array('name' => 'Depoimentos'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-format-quote',
            'supports' => array('title')
        )
    );
}

add_action('init', 'registrando_post_customizado_depoimento');

function registrando_meta_box_depoimento()
{
    add_meta_box(
        'ai_registrando_metabox',
        '--Depoimentos--',
        'depoimento_callback',
        'depoimento'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_depoimento');

function depoimento_callback($post)
{

    $depoimento_quote = get_post_meta($post->ID, '_depoimento_quote', true);
    $depoimento_nome = get_post_meta($post->ID, '_depoimento_nome', true);
    $depoimento_organizacao = get_post_meta($post->ID, '_depoimento_organizacao', true);
?>
    <label for="depoimento_quote">Depoimento - Quote</label>
    <input type="text" name="depoimento_quote" placeholder='"A Everest nos trouxe soluções eficientes de forma muita prática e rápida"' style="width: 100%" value="<?= $depoimento_quote ?>" />
    <br>
    <br>
    <label for="depoimento_nome">Nome da Pessoa</label>
    <input type="text" name="depoimento_nome" placeholder="Néviton Alves" style="width: 100%" value="<?= $depoimento_nome ?>" />
    <br>
    <br>
    <label for="depoimento_organizacao">Nome da Organização</label>
    <input type="text" name="depoimento_organizacao" placeholder="Associação Cuidado Humano" style="width: 100%" value="<?= $depoimento_organizacao ?>" />
<?php
}

function salvando_dados_metabox_depoimento($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'depoimento_quote' && $key !== 'depoimento_nome' && $key !== 'depoimento_organizacao') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_depoimento');

/**
 * FINAL DEPOIMENTO
 */



/**
 * INICIO CLIENTES


function registrando_post_customizado_clientes()
{
    register_post_type(
        'clientes',
        array(
            'labels' => array('name' => 'Clientes'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-groups',
            'supports' => array(
                'title',
                'thumbnail',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_clientes');


function registrando_meta_box_clientes()
{
    add_meta_box(
        'ai_registrando_metabox',
        '-- Clientes --',
        'clientes_callback',
        'clientes'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_clientes');

function clientes_callback($post)
{
    $cliente_resumo = get_post_meta($post->ID, '_cliente_resumo', true);
    $cliente_link = get_post_meta($post->ID, '_cliente_link', true);

?>

    <label for="cliente_resumo">Cliente - Resumo</label>
    <input type="text" name="cliente_resumo" placeholder='Lorem ipsum dolor sit amet, consectetur adipiscing elit....' style="width: 100%" value="<?= $cliente_resumo ?>" />
    <br>
    <br>
    <label for="cliente_link">Texto do Serviço - Completo</label>
    <input type="text" name="cliente_link" placeholder="http://..." style="width: 100%" value="<?= $cliente_link ?>" />
<?php
}

function salvando_dados_metabox_clientes($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'cliente_resumo' && $key !== 'cliente_link') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_clientes');
/**
 * FINAL CLIENTES
 */




/**
 * INICIO SOBRE


function registrando_post_customizado_sobres()
{
    register_post_type(
        'sobres',
        array(
            'labels' => array('name' => 'Sobre Nós'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-id-alt',
            'supports' => array(
                'title',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_sobres');


function registrando_meta_box_sobres()
{
    add_meta_box(
        'ai_registrando_metabox',
        '-- Sobre --',
        'sobres_callback',
        'sobres'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_sobres');

function sobres_callback($post)
{
    $sobre_texto = get_post_meta($post->ID, '_sobre_texto', true);
?>

    <label for="sobre_texto">Texto Sobre</label>
    <input type="text" name="sobre_texto" placeholder='Lorem ipsum dolor sit amet, consectetur adipiscing elit....' style="width: 100%" value="<?= $sobre_texto ?>" />

<?php
}

function salvando_dados_metabox_sobres($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'sobre_texto') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_sobres');
/**
 * FINAL SOBRE
 */




/**
 * INICIO NOSSOS PARCEIROS

function registrando_post_customizado_parceiros()
{
    register_post_type(
        'parceiros',
        array(
            'labels' => array('name' => 'Parceiros'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-smiley',
            'supports' => array(
                'title',
                'thumbnail',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_parceiros');

function registrando_meta_box_parceiros()
{
    add_meta_box(
        'ai_registrando_metabox',
        '-- Especialidades --',
        'parceiros_callback',
        'parceiros'
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_parceiros');

function parceiros_callback($post)
{

    $parceiro_texto = get_post_meta($post->ID, '_parceiro_texto', true);
    $parceiro_link = get_post_meta($post->ID, '_parceiro_link', true);

?>
    <label for="parceiro_texto">Texto sobre o Parceiro</label>
    <input type="text" name="parceiro_texto" placeholder='Lorem ipsum dolor sit amet, consectetur adipiscing elit....' style="width: 100%" value="<?= $parceiro_texto ?>" />
    <br>
    <br>
    <label for="parceiro_link">Link Parceiro</label>
    <input type="text" name="parceiro_link" placeholder="http://.." style="width: 100%" value="<?= $parceiro_link ?>" />

<?php
}

function salvando_dados_metabox_parceiros($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'parceiro_texto' && $key !== 'parceiro_link' && $key !== 'parceiro_cor') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_parceiros');

/**
 * FINAL NOSSOS PARCEIROS
 */



/**
 * INICIO AGENDA


function registrando_post_customizado_agenda()
{
    register_post_type(
        'agenda',
        array(
            'labels' => array('name' => 'Agenda'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array(
                'title',
                'thumbnail',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_agenda');

function registrando_meta_box_agenda()
{
    add_meta_box(
        'ai_registrando_metabox',
        '--Agenda--',
        'agenda_callback',
        'agenda',
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_agenda');

function agenda_callback($post)
{

    $agenda_data = get_post_meta($post->ID, '_agenda_data', true);
    $agenda_nome = get_post_meta($post->ID, '_agenda_nome', true);
    $agenda_texto = get_post_meta($post->ID, '_agenda_texto', true);
    $agenda_link = get_post_meta($post->ID, '_agenda_link', true);
?>
    <label for="agenda_data">Data</label>
    <input type="text" name="agenda_data" placeholder='28/Fev - 03/Mar' style="width: 100%" value="<?= $agenda_data ?>" />
    <br>
    <br>
    <label for="agenda_nome">Nome do Evento</label>
    <input type="text" name="agenda_nome" placeholder="FIFE 2021" style="width: 100%" value="<?= $agenda_nome ?>" />
    <br>
    <br>
    <label for="agenda_texto">Descrição do Evento</label>
    <input type="text" name="agenda_texto" placeholder="Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc lectus enim, molestie sed ligula nec, pellentesque rhoncus mi. Vestibulum imperdiet elementum tempus. Integer vel sollicitudin enim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Donec semper lorem eros, nec " style="width: 100%" value="<?= $agenda_texto ?>" />
    <br>
    <br>
    <label for="agenda_link">Link do Evento</label>
    <input type="text" name="agenda_link" placeholder="http://..." style="width: 100%" value="<?= $agenda_link ?>" />
<?php
}

function salvando_dados_metabox_agenda($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'agenda_data' && $key !== 'agenda_nome' && $key !== 'agenda_texto' && $key !== 'agenda_link') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_agenda');

/**
 * FINAL AGENDA
 */




/**
 * INICIO CONTATO
 

function registrando_post_customizado_contato()
{
    register_post_type(
        'contato',
        array(
            'labels' => array('name' => 'Contato'),
            'public' => true,
            'menu_position' => 30,
            'menu_icon' => 'dashicons-email-alt',
            'supports' => array(
                'title',
            )
        )
    );
}

add_action('init', 'registrando_post_customizado_contato');

function registrando_meta_box_contato()
{
    add_meta_box(
        'ai_registrando_metabox',
        '--Contato--',
        'contato_callback',
        'contato',
    );
}

add_action('add_meta_boxes', 'registrando_meta_box_contato');

function contato_callback($post)
{
    $contato_descricao = get_post_meta($post->ID, '_contato_descricao', true);
    $contato_telefone = get_post_meta($post->ID, '_contato_telefone', true);
    $contato_email = get_post_meta($post->ID, '_contato_email', true);
?>
    <label for="contato_descricao">Descrição</label>
    <input type="text" name="contato_descricao" placeholder='Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc lectus enim, molestie sed ligula nec, pellentesque rhoncus mi. Vestibulum imperdiet elementum tempus. Integer vel sollicitudin enim. ' style="width: 100%" value="<?= $contato_descricao ?>" />
    <br>
    <br>
    <label for="contato_telefone">Telefone</label>
    <input type="text" name="contato_telefone" placeholder="+55 11 0000 0000" style="width: 100%" value="<?= $contato_telefone ?>" />
    <br>
    <br>
    <label for="contato_email">E-mail</label>
    <input type="text" name="contato_email" placeholder="contato@everest.com.br" style="width: 100%" value="<?= $contato_email ?>" />
<?php
}

function salvando_dados_metabox_contato($post_id)
{
    foreach ($_POST as $key => $value) {
        if ($key !== 'contato_descricao' && $key !== 'contato_telefone' && $key !== 'contato_email') {
            continue;
        }

        update_post_meta(
            $post_id,
            '_' . $key,
            $_POST[$key]
        );
    }
}

add_action('save_post', 'salvando_dados_metabox_contato');

/**
 * FINAL CONTATO
 */
