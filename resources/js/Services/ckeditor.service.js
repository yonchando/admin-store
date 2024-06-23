import { Alignment } from "@ckeditor/ckeditor5-alignment";
import { Autoformat } from "@ckeditor/ckeditor5-autoformat";
import { BlockQuote } from "@ckeditor/ckeditor5-block-quote";
import { Bold, Italic } from "@ckeditor/ckeditor5-basic-styles";
import { Essentials } from "@ckeditor/ckeditor5-essentials";
import { Heading } from "@ckeditor/ckeditor5-heading";
import {
    Image,
    ImageCaption,
    ImageStyle,
    ImageToolbar,
    ImageUpload,
} from "@ckeditor/ckeditor5-image";
import { Indent } from "@ckeditor/ckeditor5-indent";
import { Link } from "@ckeditor/ckeditor5-link";
import { List } from "@ckeditor/ckeditor5-list";
import { MediaEmbed } from "@ckeditor/ckeditor5-media-embed";
import { Paragraph } from "@ckeditor/ckeditor5-paragraph";
import { PasteFromOffice } from "@ckeditor/ckeditor5-paste-from-office";
import { Table, TableToolbar } from "@ckeditor/ckeditor5-table";
import { TextTransformation } from "@ckeditor/ckeditor5-typing";
import {ClassicEditor} from "@ckeditor/ckeditor5-editor-classic";
import Tabs from "@/Plugins/ckeditor-tabs.js";

export default {
    editor: ClassicEditor,
    config: {
        plugins: [
            Alignment, // Adding the package to the list of plugins.
            Autoformat,
            BlockQuote,
            Bold,
            Essentials,
            Heading,
            Image,
            ImageCaption,
            ImageStyle,
            ImageToolbar,
            ImageUpload,
            Indent,
            Italic,
            Link,
            List,
            MediaEmbed,
            Paragraph,
            PasteFromOffice,
            Table,
            TableToolbar,
            TextTransformation,
            Tabs
        ],

        toolbar: {
            items: [
                'heading',
                '|',
                'alignment',
                'bold',
                'italic',
                'link',
                'bulletedList',
                'numberedList',
                '|',
                'outdent',
                'indent',
                '|',
                'imageUpload',
                'blockQuote',
                'insertTable',
                'mediaEmbed',
                'undo',
                'redo',
                'tabs',
            ],
        },
        image: {
            toolbar: ['imageStyle:inline', 'imageStyle:block', 'imageStyle:side', '|', 'toggleImageCaption', 'imageTextAlternative']
        },
    },
};
