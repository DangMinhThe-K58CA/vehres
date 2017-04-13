/**
 * @license Copyright (c) 2003-2015, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
    config.filebrowserBrowseUrl = CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'ResponsiveFilemanager' ) + 'filemanager/dialog.php?type=2&editor=ckeditor&fldr=' );
    config.filebrowserImageBrowseUrl = CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'ResponsiveFilemanager' ) + 'filemanager/dialog.php?type=1&editor=ckeditor&fldr=' );
    config.filebrowserUploadUrl = CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'kcfinder-master' ) + 'upload.php?type=files' );
    config.filebrowserImageUploadUrl = CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'kcfinder-master' ) + 'upload.php?type=images' );
    config.filebrowserFlashUploadUrl = CKEDITOR.getUrl( CKEDITOR.plugins.getPath( 'kcfinder-master' ) + 'upload.php?type=flash' );
};
