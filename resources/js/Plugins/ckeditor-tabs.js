import Editor from "@ckeditor/ckeditor5-core/src/editor/editor";
// Import inspector.
import CKEditorInspector from '@ckeditor/ckeditor5-inspector';

// Add this at the bottom of the file to inspect the editor.

/**
 * @param {Editor} editor
 */
export default function Tabs(editor) {
    
    editor.model.schema.extend("$text", {
        allowAttributes: "highlight",
    });
    
    editor.conversion.attributeToElement({
        model: 'highlight',
        view: 'mark',
    });

    CKEditorInspector.attach(editor);
}
