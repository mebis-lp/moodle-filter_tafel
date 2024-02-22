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
 * @package    filter_tafel
 * @copyright  2018 Franziska Hübler, ISB Bayern
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

/**
 * Filter class for mebis-Tafel links.
 *
 * @package    filter_tafel
 * @copyright  2018 Franziska Hübler, ISB Bayern
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_tafel extends moodle_text_filter {

    /**
     * Filter the text and replace the links to mebis-Tafel with an
     * suitable iframe.
     *
     * Please note that we replace links NOT urls. If it should be possible to
     * convert a url, you have to filter the text with filter_urltolink before
     * applying this filter.
     *
     * @param string $text some HTML content
     * @param array $options options passed to the filters
     * @return string the HTML content after the filtering has been applied
     */
    public function filter($text, array $options = []) {

        if (!is_string($text) || empty($text)) {
            return $text;
        }

        if (stripos($text, '</a>') === false) {
            // Performance shortcut - if not </a> tag, nothing can match.
            return $text;
        }

        $serverstring = get_config('filter_tafel', 'server_name');

        $regex = "%<a[^>]?href=\"((http|https)://($serverstring)/tafel/.*?)\".*?</a>%is";
        $newtext = preg_replace_callback($regex, [$this, 'filter_tafel_callback'], $text);

        return $newtext;
    }

    /**
     * Embed mebis-Tafel item in a iframe.
     *
     * @param array $match
     * @return string HTML fragment
     */
    protected function filter_tafel_callback($match) {

        $link = $match[1];

        $pos = strrpos($link, 'tafel');

        if ($pos === false) {
            // Wrong link.
            return $match[0];
        }

        $link = substr_replace($link, 'frame', $pos, 5);

        $iframeattributes = [
            'class' => 'mebis-tafel-frame embed-responsive-item',
            'src' => $link,
            'allowfullscreen' => 'allowfullscreen',
        ];

        $out = html_writer::tag('iframe', '', $iframeattributes);
        return html_writer::tag('div', $out, ['class' => 'embed-responsive embed-responsive-4by3']);
    }

}
