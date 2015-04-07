<?php

class forms{

	static function title($at){
        echo '<h1>'.$at['title'].'</h1>'."\n\n";
    }

    static function button($at){
        $style = isset($at['style']) ? $at['style'] : false;
		$target = isset($at['target']) ? $at['target'] : false;
        
        echo '<a class="headButtons"';
        echo ' href="'.$at['link'].'"';
        if(isset($at['rel'])) echo ' rel="'.$at['rel'].'"';
        if($style) echo ' style="'.$style.'"';
        if($target) echo ' target="'.$target.'"';
        echo '>';
        echo $at['value'];
        echo '</a>'."\n\n";
    }

    static function itemsOpen($at){
        $show_as_grid = isset($at['show_as_grid']) && $at['show_as_grid'] == 1 ? 1 : 0;
        echo '<div class="items';
        if($show_as_grid) echo ' grid';
        echo '">'."\n\n";
    }

    static function itemsClose($at){
        echo '</div><!-- items -->'."\n\n";
    }

    static function item($at){
        $active = isset($at['active']) && $at['active'] == 1 ? 1 : 0;
        $activeIcon = isset($at['activeIcon']) ? $at['activeIcon'] : 'status';
        $activeIcon = $activeIcon == 'status' ? 'status'.$active : $activeIcon;
        $activeHardLink = isset($at['activeHardLink']) ? 1 : 0;
        $activeLabel = isset($at['activeLabel']) ? $at['activeLabel'] : 0;
        $hideActive = isset($at['hideActive']) ? 1 : 0;
        $hideDelete = isset($at['hideDelete']) ? 1 : 0;
        $hideEdit = isset($at['hideEdit']) ? 1 : 0;
        $deleteHardLink = isset($at['deleteHardLink']) ? 1 : 0;
        $icon = isset($at['icon']) ? $at['icon'] : 'document';
        $image = isset($at['image']) ? $at['image'] : 0;
        $imageLink = isset($at['imageLink']) ? $at['imageLink'] : 0;
        $imageLinkClass = isset($at['imageLinkClass']) ? $at['imageLinkClass'] : 0;
        $id = isset($at['id']) ? $at['id'] : 0;
        $itemClass = isset($at['itemClass']) ? ' '.$at['itemClass'] : '';
        $parent = isset($at['parent']) ? $at['parent'] : '';
        $title = isset($at['title']) ? nl2br($at['title']) : '';
        $subTitle = isset($at['subTitle']) ? nl2br($at['subTitle']) : '';
        $actions = isset($at['actions']) ? $at['actions'] : false;

        echo '<div class="item'.$itemClass.'" id="item_'.$id.'">';
        echo '<table cellspacing="15"><tr>';

        // ICON
        echo '<td class="widthOne">';
        if($image){
            if($imageLink) echo '<a class="noCover '.$imageLinkClass.'" href="'.$imageLink.'">';
            if($image) echo '<img alt="" src="'.$image.'" title="" />';
            if($imageLink) echo '</a>';
        }else{
            echo '<img alt="" class="itemIcon" src="'.url::base().'inc/cms/img/crystalClear/50/'.$icon.'.gif" title="" />';
        }

        echo '</td>';

        // TITLE
        echo '<td class="itemTitles">';
        if(!empty($title)){ echo '<div class="itemTitle">'.$title.'</div>'; }
        if(!empty($subTitle)){ echo '<div class="itemSubTitle">'.$subTitle.'</div>'; }
        echo '</td>';

        if($actions){
            foreach($actions as $action){
                echo '<td class="itemAction">';
                echo '<a class="'.(isset($action['class']) ? $action['class'] : '').'" href="'.$action['link'].'" rel="'.(isset($action['rel']) ? $action['rel'] : '').'">';
                echo '<img alt="'.$action['label'].'"
                           class="actionIcon" src="'.$action['icon'].'"
                           title="'.$action['label'].'" /><br />'.$action['label'].'';
                echo '</a>';
                echo '</td>';
            }
        }else{
            // ACTIVE
            if(!$hideActive){
                echo '<td class="center widthOne">';
                if(!empty($activeHardLink)) echo '<a href="'.url::page(CONTROLLER.'/active/'.$id).'">';
                else echo '<a href="javascript: itemActive(\''.url::page(CONTROLLER).'\',\''.$id.'\');">';            
                echo '<img alt="pokaż / ukryj"
                           class="actionIcon"
                           id="itemStatus'.$id.'"
                           src="'.url::base().'inc/cms/img/crystalClear/35/'.$activeIcon.'.gif';
                echo '" title="pokaż / ukryj" />';
                if(!empty($activeLabel)) echo '<span class="actionIconLabel">'.$activeLabel.'</span>';
                echo '</a>';
                echo '</td>';
            }

            // EDIT
            if(!$hideEdit){
                echo '<td class="center widthOne">';
                echo '<a href="'.url::page(CONTROLLER.'/form/'.$id);
                if(!empty($parent)){ echo '/'.$parent; }
                echo '">';
                echo '<img alt="edytuj"
                           class="actionIcon" src="'.url::base().'inc/cms/img/crystalClear/35/edit.gif"
                           title="edytuj" />';
                echo '</a>';
                echo '</td>';
            }

            // DELETE
            if(!$hideDelete){
                echo '<td class="center widthOne">';
                if(!empty($deleteHardLink)) echo '<a href="'.url::page(CONTROLLER.'/delete/'.$id).'">';
                else echo '<a href="javascript: itemDelete(\''.url::page(CONTROLLER).'\',\''.$id.'\');">';
                echo '<img alt="usuń"
                           class="actionIcon" src="'.url::base().'inc/cms/img/crystalClear/35/delete.gif"
                           title="usuń" />';
                echo '</a>';
                echo '</td>';
            }
        }
        echo '</tr></table>';
        echo '</div>'."\n\n";
    }

    static function item_grid($at){
        $active = isset($at['active']) && $at['active'] == 1 ? 1 : 0;
        $hideActive = isset($at['hideActive']) ? 1 : 0;
        $hideDelete = isset($at['hideDelete']) ? 1 : 0;
        $hideEdit = isset($at['hideEdit']) ? 1 : 0;
        $icon = isset($at['icon']) ? $at['icon'] : 'document';
        $image = isset($at['image']) ? $at['image'] : 0;
        $id = isset($at['id']) ? $at['id'] : 0;
        $itemClass = isset($at['itemClass']) ? ' '.$at['itemClass'] : '';
        $preview = isset($at['preview']) ? $at['preview'] : 0;
        $insert_file_to_editor = isset($at['insert_file_to_editor']) && $at['insert_file_to_editor'] ? $at['insert_file_to_editor'] : 0;
        $title = isset($at['title']) ? strip_tags($at['title']) : '';
        $push_image_id = isset($at['push_image_id']) && $at['push_image_id'] ? $at['push_image_id'] : 0;

        echo '<div class="item'.$itemClass.'" id="item_'.$id.'" style="float: left; width: auto;">';
        echo '<table cellspacing="15" style="width: auto;"><tr>';

        // ICON
        echo '<td>';

        // image or icon
        echo '<img alt="'.$title.'" class="image';
        if(isset($at['active']) && $at['active'] == 0) echo ' alpha_35';
        echo '" src="'.url::base().'inc/cms/img/s.gif" style="background-image: url(\''.($image ? $image : url::base().'inc/cms/img/crystalClear/50/'.$icon.'.gif').'\');" title="'.$title.'" />';

        echo '<div class="actions">';

        if($insert_file_to_editor){
            echo '<a href="#"
                     onclick="insert_image(\''.$insert_file_to_editor.'\'); return false;"
                     style="background-image: url('.url::base().'/inc/cms/img/crystalClear/20/arrow.gif);">
                Wstaw na stronę
            </a>';
        }

        if($push_image_id){
            echo '<a href="#"
               onclick="push_image_id(\''.$push_image_id.'\', \''.$id.'\'); return false;"
               style="background-image: url('.url::base().'/inc/cms/img/crystalClear/20/arrow.gif);">
                Użyj tego obrazu
            </a>';
        }


        if($preview){
            echo '<a href="'.$preview.'"
                     style="background-image: url(\''.url::base().'/inc/cms/img/crystalClear/20/file.gif\');">
                    Podgląd
                </a>';
        }

        if(!$hideActive){
            echo '<a href="'.url::page(CONTROLLER.'/active/'.$id).'"
                     style="background-image: url(\''.url::base().'/inc/cms/img/crystalClear/20/status'.$active.'.gif\');">';
                    if($active) echo 'Wyłącz';
                    else echo 'Włącz';
            echo '</a>';
        }

        if(!$hideEdit){
            echo '<a href="'.url::page(CONTROLLER.'/form/'.$id).'"
                     style="background-image: url(\''.url::base().'/inc/cms/img/crystalClear/20/edit.gif\');">
                    Edytuj
                </a>';
        }

        if(!$hideDelete){
            echo '<a href="javascript: itemDeleteInline(\''.url::page(CONTROLLER.'/delete/'.$id).'\');"
                   style="background-image: url(\''.url::base().'/inc/cms/img/crystalClear/20/delete.gif\');">
                    Usuń
                </a>';
        }
        echo '</div>';
        echo '</td>';


        /*

        // ACTIVE
        if(!$hideActive){
            echo '<td class="center widthOne">';
            echo '<a href="javascript: itemActive(\''.url::page(CONTROLLER).'\',\''.$id.'\');">';            
            echo '<img alt="pokaż / ukryj"
                       class="actionIcon"
                       id="itemStatus'.$id.'"
                       src="'.url::base().'inc/cms/img/crystalClear/35/status'.$active.'.gif';
            echo '" title="pokaż / ukryj" />';
            echo '</a>';
            echo '</td>';
        }

        // EDIT
        if(!$hideEdit){
            echo '<td class="center widthOne">';
            echo '<a href="'.url::page(CONTROLLER.'/form/'.$id);
            if(!empty($parent)){ echo '/'.$parent; }
            echo '">';
            echo '<img alt="edytuj"
                       class="actionIcon" src="'.url::base().'inc/cms/img/crystalClear/35/edit.gif"
                       title="edytuj" />';
            echo '</a>';
            echo '</td>';
        }

        // DELETE
        if(!$hideDelete){
            echo '<td class="center widthOne">';
            if(!empty($deleteHardLink)) echo '<a href="'.url::page(CONTROLLER.'/delete/'.$id).'">';
            else echo '<a href="javascript: itemDelete(\''.url::page(CONTROLLER).'\',\''.$id.'\');">';
            echo '<img alt="usuń"
                       class="actionIcon" src="'.url::base().'inc/cms/img/crystalClear/35/delete.gif"
                       title="usuń" />';
            echo '</a>';
            echo '</td>';
        }
        */
        echo '</tr></table>';
        echo '</div>'."\n\n";
    }

    static function itemsMove($at){
        echo '
        <script type="text/javascript">
            $(document).ready(function(){
                itemMove();
            });
        </script>
        ';
    }

    static function open($at){
        $action = isset($at['action']) ? $at['action'] : '#';
        $method = isset($at['method']) ? $at['method'] : 'post';
        $onSubmit = isset($at['onSubmit']) ? $at['onSubmit'] : '';
        $target = isset($at['target']) ? $at['target'] : false;

        echo '<form action="'.$action.'" enctype="multipart/form-data" ';
        if(!empty($onSubmit)){ echo 'onsubmit="'.$onSubmit.'" '; }
        if($target){ echo 'target="'.$target.'" '; }
        echo 'method="'.$method.'">'."\n\n";
    }

    static function close($at){
        echo '</form>'."\n\n";
    }

    static function line($at){
        echo '<div class="clear"></div><hr style="margin: 20px 0;" /><div class="clear"></div>'."\n\n";
    }

    static function text($at){
        $fieldClass = isset($at['fieldClass']) ? 'formField '.$at['fieldClass'] : 'formField';
        $id = isset($at['id']) ? $at['id'] : $at['name'].'Id';
        $inputClass = isset($at['inputClass']) ? ' '.$at['inputClass'] : '';
        $inputStyle = isset($at['inputStyle']) ? $at['inputStyle'] : '';
        $inputType = isset($at['inputType']) ? $at['inputType'] : 'text';
        $label = isset($at['label']) ? $at['label'] : '';
        $name = isset($at['name']) ? $at['name'] : '';
        $readonly = isset($at['readOnly']) && $at['readOnly'] == 1 ? 1 : 0;
        $required = isset($at['required']) ? $at['required'] : 0;
        $subLabel = isset($at['subLabel']) ? $at['subLabel'] : '';
        $value = isset($at['value']) ? self::convert_quotes($at['value']) : '';

        echo '<div class="'.$fieldClass.'" id="field_'.$id.'"><div class="i">';

        $disabled = '';
        if($readonly){
            self::hidden(array('id' => $id,
                               'name' => $name,
                               'value' => $value));
           $disabled = '_disabled';
        }

        if($label){
            echo '<label id="'.$id.'_label" for="'.$id.$disabled.'">';
            echo $label;
            if(!empty($required)) echo ' <b class="red">*</b>';
            echo '</label>';
        }

        echo '<input class="formText'.$inputClass.'" id="'.$id.$disabled.'" name="'.$name.$disabled.'" ';
        if($readonly){ echo 'readonly="readonly" disabled="disabled" '; }
        if(!empty($inputStyle)){ echo 'style="'.$inputStyle.'" '; }
        echo 'type="'.$inputType.'" value="'.$value.'" />'."\n";

        if(!empty($subLabel)) echo '<div class="subLabel">'.$subLabel.'</div>';

        echo '</div></div>';

    }

    static function textarea($at){
        $fieldClass = isset($at['fieldClass']) ? 'formField '.$at['fieldClass'] : 'formField';
        $editor = isset($at['editor']) && $at['editor'] == 1 ? ' editor' : '';
        $id = isset($at['id']) ? $at['id'] : $at['name'].'Id';
        $inputClass = isset($at['inputClass']) ? ' '.$at['inputClass'] : '';
        $inputStyle = isset($at['inputStyle']) ? $at['inputStyle'] : '';
        $label = isset($at['label']) ? $at['label'] : '';
        $name = isset($at['name']) ? $at['name'] : '';
        $required = isset($at['required']) ? 1 : 0;
        $subLabel = isset($at['subLabel']) ? $at['subLabel'] : '';
        $value = isset($at['value']) ? $at['value'] : '';

        echo '<div class="'.$fieldClass.'"><div class="i">';

        if($label){
            echo '<label for="'.$id.'">';
            echo $label;
            if(!empty($required)) echo ' <b class="red">*</b>';
            echo '</label>';
        }

        echo '<textarea class="formTextarea'.$inputClass.$editor.'" cols="1" id="'.$id.'" name="'.$name.'" rows="1" ';
        if(!empty($inputStyle)){ echo 'style="'.$inputStyle.'" '; }
        echo '>'.$value.'</textarea>'."\n";

        if(!empty($subLabel)) echo '<div class="subLabel">'.$subLabel.'</div>';

        echo '</div></div>';
    }

    static function select($at){
        $fieldClass = isset($at['fieldClass']) ? 'formField '.$at['fieldClass'] : 'formField';
        $data = isset($at['data']) ? $at['data'] : 0;
        $default = isset($at['default']) && $at['default'] ? $at['default'] : false;
        $id = isset($at['id']) ? $at['id'] : $at['name'].'Id';
        $inputClass = isset($at['inputClass']) ? ' '.$at['inputClass'] : '';
        $inputStyle = isset($at['inputStyle']) ? $at['inputStyle'] : '';
        $label = isset($at['label']) ? $at['label'] : '';
        $labels = isset($at['labels']) ? $at['labels'] : '';
        $labelClass = isset($at['labelClass']) ? $at['labelClass'] : '';
        $name = isset($at['name']) ? $at['name'] : '';
        $readonly = isset($at['readOnly']) && $at['readOnly'] == 1 ? 1 : 0;
        $rels = isset($at['rels']) ? $at['rels'] : 0;
        $subLabel = isset($at['subLabel']) ? $at['subLabel'] : '';
        $value = isset($at['value']) ? self::convert_quotes($at['value']) : '';
        $values = isset($at['values']) ? $at['values'] : '';
        $required = isset($at['required']) ? 1 : 0;

        echo '<div class="'.$fieldClass.'" id="field_'.$id.'"><div class="i">';
        
        $disabled = '';
        if($readonly){
            self::hidden(array('id' => $id,
                               'name' => $name,
                               'value' => $value));
           $disabled = '_disabled';
        }

        if($label){
            echo '<label for="'.$id.$disabled.'">';
            echo $label;
            if(!empty($required)) echo ' <b class="red">*</b>';
            echo '</label>';
        }

        echo '<select class="formSelect'.$inputClass.'" id="'.$id.$disabled.'" name="'.$name.$disabled.'" ';
        if($readonly){ echo 'disabled="disabled" '; }
        if(!empty($inputStyle)){ echo 'style="'.$inputStyle.'" '; }
        echo '>'."\n";

        if($default) echo '<option value="0">'.$default.'</option>';
        if($data){
            foreach($data as $item){
                $selected = 0; if($item[$values] == $value){ $selected = 1; }
                echo '<option ';
                if($rels) echo 'rel="'.$item[$rels].'" ';
                if($selected) echo 'selected="selected" ';
                echo 'value="'.$item[$values].'">'.$item[$labels].'</option>';
            }
        }

        echo '</select>';

        if(!empty($subLabel)) echo '<div class="subLabel">'.$subLabel.'</div>';

        echo '</div></div>';

    }

    static function info($at){
        $fieldClass = isset($at['fieldClass']) ? 'formField '.$at['fieldClass'] : 'formField';
        $value = isset($at['value']) ? nl2br($at['value']) : '';

        echo '<div class="'.$fieldClass.'"><div class="i">';

        echo $value."\n";

        echo '</div></div>';
    }

    static function submit($at){
        $fieldClass = isset($at['fieldClass']) ? 'formField '.$at['fieldClass'] : 'formField';
        $inputClass = isset($at['inputClass']) ? ' '.$at['inputClass'] : '';
        $keepEditing = isset($at['keepEditing']) && PARAM ? 1 : 0;
        $label = isset($at['label']) ? $at['label'] : 'Zapisz';

        echo '<div class="'.$fieldClass.'"><div class="i">';

        echo '<input class="formButton'.$inputClass.'" type="submit" value="'.$label.'" />';

        if($keepEditing){
            echo '<input id="redirectBackId" name="redirectBack" type="hidden" value="0" />';
            echo '&nbsp; &nbsp; <input class="formButton" id="keepEditingButton" type="submit" value="Zapisz i kontynuuj edycję" />';
        }

        if(isset($at['after'])) echo $at['after'];

        echo '</div></div>';
    }

    static function checkbox($at){
        $fieldClass = isset($at['fieldClass']) ? 'formField '.$at['fieldClass'] : 'formField';
        $checked = (isset($at['checked']) && $at['checked'] == 1) ? 1 : 0;
        $id = isset($at['id']) ? $at['id'] : $at['name'].'Id';
        $inputClass = isset($at['inputClass']) ? ' '.$at['inputClass'] : '';
        $label = isset($at['label']) ? $at['label'] : '';
        $name = isset($at['name']) ? $at['name'] : '';
        $value = isset($at['value']) ? $at['value'] : 1;
        $required = isset($at['required']) ? 1 : 0;

        echo '<div class="'.$fieldClass.'"><div class="i">';

        echo '<input ';
        if($checked){ echo 'checked="checked" '; }
        echo 'class="'.$inputClass.'" id="'.$id.'" name="'.$name.'" type="checkbox" value="'.$value.'" />&nbsp;&nbsp;';

        echo '<label for="'.$id.'" style="display: inline;">'.$label;
        if(!empty($required)){ echo ' <b class="red">*</b>'; }
        echo '</label>'."\n";

        echo '</div></div>';
    }

    static function hidden($at){
        $id = isset($at['id']) ? $at['id'] : $at['name'].'Id';
        $inputClass = isset($at['inputClass']) ? $at['inputClass'] : '';
        $name = isset($at['name']) ? $at['name'] : '';
        $value = isset($at['value']) ? $at['value'] : '';

        echo '<div class="hidden">'."\n";
        echo '<input class="'.$inputClass.'" id="'.$id.'" name="'.$name.'" type="hidden" value="'.$value.'" />'."\n";
        echo '</div>'."\n\n";
    }

    static function pagination($at){
        $data = isset($at['data']) ? $at['data'] : false;
        $link = isset($at['link']) ? $at['link'] : '';
        if($data && ($data -> next() || $data -> prev())){
            echo '<hr style="margin-top: 0;" />';

            echo '<p class="center">';

            if($data -> next()){
            	echo '<a class="headButtons"  href="'.url::page($link.'/'.$data -> next_page()).'" style="float: right;">';
            	echo 'Dalej &#187;';
            	echo '</a>';
            }

            if($data -> prev()){
            	echo '<a class="headButtons floatLeft" href="'.url::page($link.'/'.$data -> prev_page()).'" style="float: left;">';
            	echo '&#171; Wstecz';
                echo '</a>';
            }

            echo 'Strona '.($data -> current_page()).' z '.($data -> total());

            echo '</p>';
        }
    }

    // CONVERT QUOTES TO FORM INPUT READABLE
    static function convert_quotes($a){
    	$a = str_replace('"','&quot;',$a);
    	return $a;
    }

    // READABLE URL
    static function niceUrl($a){
        $a = str_replace('http://', '', $a);
        $a = str_replace('www.', '', $a);

        return $a;
    }

}

?>