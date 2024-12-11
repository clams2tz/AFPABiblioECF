import { startStimulusApp } from '@symfony/stimulus-bundle';
import './styles/app.css';


import { Application } from '@hotwired/stimulus';
import { definitionsFromContext } from '@hotwired/stimulus-webpack-helpers';
const app = startStimulusApp();
const application = Application.start();
const context = require.context('./controllers', true, /\.js$/);
application.load(definitionsFromContext(context));
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
