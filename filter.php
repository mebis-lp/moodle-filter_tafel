<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Filter class.
 *
 * @package    filter_notes
 * @copyright  2018 Franziska Hübler, ISB Bayern
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
defined('MOODLE_INTERNAL') || die();

class filter_notes extends moodle_text_filter {

    /**
     * Filter the text and replace the links to notes with an
     * suitable iframe.
     *
     * Please note that we replace links NOT urls. If it should be possible to
     * convert a url, you have to filter the text with filter_urltolink before
     * applying this filter.
     *
     * @param string $text
     * @param array $options
     * @return string
     */
    public function filter($text, array $options = array()) {
        
        if (!is_string($text) or empty($text)) {
            return $text;
        }
        
        if (stripos($text, '</a>') === false) {
            // Performance shortcut - if not </a> tag, nothing can match.
            return $text;
        }

        $serverstring = get_config('filter_notes', 'server_name');
        
        $regex = "%<a[^>]?href=\"((http|https)://notes.($serverstring)/notes/.*?)\".*?</a>%is";
        $newtext = preg_replace_callback($regex, [$this, 'filter_notes_callback'], $text);

        return $newtext;
    }
    
    /**
     * Embed notes item in a iframe.
     *
     * @param array $match
     */
    protected function filter_notes_callback($match) {

        $link = $match[1];
   
        $pos = strrpos($link, 'notes');
        
        if ($pos === false) { 
            // Wrong link.
            return $match[0];
        }
        
        $link = substr_replace($link, 'frame', $pos, 5);

        $iframeattributes = [
            'class' => 'notes-frame embed-responsive-item',
            'src' => $link,
            'allowfullscreen' => 'allowfullscreen'
        ];

        $out = html_writer::tag('iframe', '', $iframeattributes);
        return html_writer::tag('div', $out, ['class' => 'embed-responsive embed-responsive-4by3']);
    }
    
}