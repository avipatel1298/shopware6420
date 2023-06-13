import template from './sw-promotion-v2-detail-base.html.twig';

const {Component} = Shopware;
const {Criteria} = Shopware.Data;

Component.override('sw-promotion-v2-detail-base', {
    template,

    inject: [
        'repositoryFactory',
    ],

    data() {
        return {
            repositoryAddMedia: null,
            mediaUploadTag: 'sw-profile-upload-tag',
            isSaveSuccessful: false,
            desktopLogo: null,
            showMediaModal: false,
        };
    },

    created() {
        this.repositoryAddMedia = this.repositoryFactory.create('ict_upload_promotion_icon');

    },


    computed: {
        mediaRepository() {
            return this.repositoryFactory.create('media');
        },

        promotionLogoRepository() {
            return this.repositoryFactory.create('ict_upload_promotion_icon');
        }
    },
    methods: {
        loadMediaPreview(mediaId) {
            if (!mediaId) return
            this.mediaRepository.get(mediaId).then((response) => {

                this.desktopLogo = response;

            });

        },

        setMediaItem({ targetId }) {

            console.log(targetId);
            this.loadMediaPreview(targetId);

            if (!this.promotion.extensions.promotionId) {
                this.promotion.extensions.promotionId = this.promotionLogoRepository.create()
            }
            this.promotion.extensions.promotionId.mediaId = targetId
            this.promotion.extensions.promotionId.promotionId = this.promotion.id
            console.log(this.promotion);

        },

        // onClickEditDomain(domain) {
        //     this.currentDomain = domain;
        //     this.setCurrentDomainBackup(this.currentDomain);
        //     if (this.currentDomain.extensions.SalesDomainId) {
        //         this.loadMediaPreview(this.currentDomain.extensions.SalesDomainId.mediaId)
        //     }
        // },

        // onCloseCreateDomainModal() {
        //     this.resetCurrentDomainToBackup();
        //     this.currentDomain = null;
        //     this.desktopLogo = null
        // },

        onDropMedia(dragData) {
            this.setMediaItem({ targetId: dragData.id });
        },

        // onMediaSelectionChange(mediaItems) {
        //     const media = mediaItems[0];
        //     this.loadMediaPreview(media.id)
        //     if (!this.currentDomain.extensions.SalesDomainId) {
        //         this.currentDomain.extensions.SalesDomainId = this.salesDomainLogoRepository.create()
        //     }
        //     this.currentDomain.extensions.SalesDomainId.salesChannelDomainId = this.currentDomain.id
        //     this.currentDomain.extensions.SalesDomainId.salesChannelId = this.salesChannel.id
        //     this.currentDomain.extensions.SalesDomainId.mediaId = media.id
        // },

        onUnlinkLogo() {
            if (this.promotion.extensions.promotionIconImage) {
                this.promotion.extensions.promotionIconImage.mediaId = null
            }
            this.desktopLogo = null
        },
    }
});
