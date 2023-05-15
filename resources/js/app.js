import Alpine from 'alpinejs'
import FormsAlpinePlugin from '../../vendor/filament/forms/dist/module.esm'
import NotificationsAlpinePlugin from '../../vendor/filament/notifications/dist/module.esm'
import Collapse from '@alpinejs/collapse'

Alpine.plugin(FormsAlpinePlugin)
Alpine.plugin(NotificationsAlpinePlugin)
Alpine.plugin(Collapse)

window.Alpine = Alpine

Alpine.start()
