<?php
/**
 * Plugin Name: Первый виджет
 * Description: Тут описание
 * Plugin URI: /
 */

// Для вывода категорий
// wp_list_categories()
// к ней можно применить фильтр
// Как я понял к любой функции можно применить фильтр

// Для селекта
// selected()

add_action('widgets_init', 'wfm_first_widget');

function wfm_first_widget()
{
    register_widget('WFM_Widget');
}

class WFM_Widget extends WP_Widget
{
    public function __construct()
    {
        $params = [
            'name'        => 'Мой первый виджет',
            'description' => 'Описание моего виджета',
            'classname'   => 'wfm_test',
        ];

        parent::__construct(
            'wfm_fw',
            '',
            $params
        );
    }

    public function widget($args, $instance)
    {
        extract($args);
        extract($instance);

        $title = apply_filters('widget_title', $title);
        $text  = apply_filters('widget_text', $text);

        echo $before_widget;
        echo $before_title . $title . $after_title;
        echo $text;
        echo $after_widget;
    }

    public function form($instance)
    {
        extract($instance);

        if (!isset($title)) {
            $title = '';
        } else {
            $title = esc_attr($title);
        }

        if (!isset($text)) {
            $text = '';
        } else {
            $text = esc_attr($text);
        }

        echo '
        <p>
            <label for="' . $this->get_field_id('title') . '">Заголовок: </label>
            <input 
            type="text" 
            name="' . $this->get_field_name('title') . '" 
            id="' . $this->get_field_id('title') . '" 
            value="' . $title . '" 
            class="widefat"
            >
        </p>
        
        <p>
            <label for="' . $this->get_field_id('text') . '">Текст: </label>
            <textarea 
            name="' . $this->get_field_name('text') . '" 
            id="' . $this->get_field_id('text') . '" 
            cols="20" 
            rows="5"
            >' . $text . '</textarea>
        </p>
        ';
    }

    /**
     * Для манипуляциями с записями при обновлении
     *
     * @param array $new_instance
     * @param array $old_instance
     * @return array
     */
    public function update($new_instance, $old_instance)
    {
        $new_instance['title'] = !empty($new_instance['title']) ? strip_tags($new_instance['title']) : '';

        return $new_instance;
    }
}