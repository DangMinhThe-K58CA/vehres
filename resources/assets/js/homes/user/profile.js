import previewImage from '../../helpers/imageHelper';

export default class Profile
{
    constructor(app) {
        this.app = app;
        this.window = app.window;
        this.jQuery = app.jQuery;
    }

    init() {
        const $ = this.jQuery;
        var input = $('#avatar');
        input.on('change', (event) => {
            this.previewAvatar(event.target, 'previewField');
        });
    }

    previewAvatar(input, previewFieldId) {
        previewImage(input, previewFieldId);
    }
}
