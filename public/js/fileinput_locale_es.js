/*!
 * FileInput Spanish (Latin American) Translations
 *
 * This file must be loaded after 'fileinput.js'. Patterns in braces '{}', or
 * any HTML markup tags in the messages must not be converted or translated.
 *
 * @see http://github.com/kartik-v/bootstrap-fileinput
 *
 * NOTE: this file must be saved in UTF-8 encoding.
 */
(function ($) {
    "use strict";

    $.fn.fileinputLocales['es'] = {
        fileSingle: 'archivo',
        filePlural: 'archivos',
        browseLabel: 'Buscar &hellip;',
        removeLabel: 'Eliminar',
        removeTitle: 'Limpiar archivos seleccionados',
        cancelLabel: 'Cancelar',
        cancelTitle: 'Abortar carga en curso',
        uploadLabel: 'Subir archivo',
        uploadTitle: 'Subir archivos seleccionados',
        msgSizeTooLarge: 'Archivo "{name}" (<b>{size} KB</b>) excede el tamaño máximo permitido de <b>{maxSize} KB</b>. Por favor, inténtelo de nuevo.',
        msgFilesTooLess: 'Debe seleccionar al menos <b>{n}</b> {files} a subir. Por favor, inténtelo de nuevo.',
        msgFilesTooMany: 'El número de archivos seleccionados a subir <b>({n})</b> excede el límite máximo permitido de <b>{m}</b>. Por favor, inténtelo de nuevo.',
        msgFileNotFound: 'Archivo "{name}" no encontrado!',
        msgFileSecured: 'Restricciones de seguridad previenen la lectura del archivo "{name}".',
        msgFileNotReadable: 'Archivo "{name}" no se puede leer.',
        msgFilePreviewAborted: 'Previsualización del archivo abortada para "{name}".',
        msgFilePreviewError: 'Ocurrió un error mientras se leía el archivo "{name}".',
        msgInvalidFileType: 'Tipo de archivo inválido para el archivo "{name}". Sólo archivos "{types}" son permitidos.',
        msgInvalidFileExtension: 'Extensión de archivo inválido para "{name}". Sólo archivos "{extensions}" son permitidos.',
        msgValidationError: 'Error subiendo archivo',
        msgLoading: 'Subiendo archivo {index} de {files} &hellip;',
        msgProgress: 'Subiendo archivo {index} de {files} - {name} - {percent}% completado.',
        msgSelected: '{n} {files} seleccionados',
        msgFoldersNotAllowed: 'Arrastre y suelte únicamente archivos! Se omite {n} carpeta(s).',
        dropZoneTitle: 'Arrastre y suelte los archivos aquí &hellip;'
    };
})(window.jQuery);