// Load all the modules from package.json
var gulp = require( 'gulp' ),
    plumber = require( 'gulp-plumber' ),
    autoprefixer = require('gulp-autoprefixer'),
    watch = require( 'gulp-watch' ),
    livereload = require( 'gulp-livereload' ),
    minifycss = require( 'gulp-minify-css' ),
    jshint = require( 'gulp-jshint' ),
    stylish = require( 'jshint-stylish' ),
    uglify = require( 'gulp-uglify' ),
    rename = require( 'gulp-rename' ),
    notify = require( 'gulp-notify' ),
    include = require( 'gulp-include' ),
    htmlmin = require('gulp-htmlmin'),
    concat = require('gulp-concat'),
    sass = require( 'gulp-sass' );
imagemin = require('gulp-imagemin');
bower = require('gulp-bower');

var config = './bower_components';


// Default error handler
var onError = function( err ) {
    console.log( 'An error occured:', err.message );
    this.emit('end');
}

// Install all Bower components
gulp.task('bower', function() {
    return bower()
        .pipe(gulp.dest(config))
});


// Jshint outputs any kind of javascript problems you might have
// Only checks javascript files inside /src directory
gulp.task( 'jshint', function() {
    return gulp.src( './js/src/*.js' )
        .pipe( jshint() )
        .pipe( jshint.reporter( stylish ) )
        .pipe( jshint.reporter( 'fail' ) );
})



gulp.task( 'scripts', ['jshint'], function() {
    return gulp.src('./js/*.js')
        .pipe( include() )
        .pipe( rename( { basename: 'scripts' } ) )
        .pipe( gulp.dest( './js/dist' ) )
        // Normal done, time to create the minified javascript (scripts.min.js)
        // remove the following 3 lines if you don't want it
        .pipe( uglify() )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe(concat('all.min.js'))
        .pipe( gulp.dest( './js/dist' ) )
        .pipe(notify({ message: 'scripts task complete' }))
        .pipe( livereload() );
} );



// As with javascripts this task creates two files, the regular and
// the minified one. It automatically reloads browser as well.
var options = {};
options.sass = {
    errLogToConsole: true,
    sourceMap: 'sass',
    sourceComments: 'map',
    precision: 10,
    //imagePath: 'assets/img',
    includePaths: [
        config + '/bootstrap-sass/assets/stylesheets'
    ]
};
options.autoprefixer = {
    map: true
    //from: 'sass',
    //to: 'asrp.min.css'
};

gulp.task('sass', function() {
    return gulp.src('./css/style.scss')
        .pipe( plumber( { errorHandler: onError } ) )
        .pipe(sass(options.sass))
        .pipe(autoprefixer('last 2 version', 'safari 5', 'ie 8', 'ie 9', 'opera 12.1', 'ios 6', 'android 4',
            options.autoprefixer
        ))
        .pipe( gulp.dest( '.' ) )
        .pipe( minifycss() )
        .pipe( rename( { suffix: '.min' } ) )
        .pipe( gulp.dest( '.' ) )
        .pipe(notify({ message: 'sass task complete' }))
        .pipe( livereload() );
});

// Optimize Images
gulp.task('images', function() {
    return gulp.src('./img/**/*')
        .pipe(imagemin({ progressive: true, svgoPlugins: [{removeViewBox: false}]}))
        .pipe(gulp.dest('./img'))
        .pipe(notify({ message: 'Images task complete' }));
});


// Start the livereload server and watch files for change
gulp.task( 'watch', function() {
    livereload.listen();

    // don't listen to whole js folder, it'll create an infinite loop
    gulp.watch( [ './js/**/*.js', '!./js/dist/*.js' ], [ 'scripts' ] );

    gulp.watch( './css/**/*.scss', ['sass'] );

    gulp.watch('./img/**/*', ['images']);


    gulp.watch( './**/*.php' ).on( 'change', function( file ) {
        // reload browser whenever any PHP file changes
        livereload.changed( file );
    } );
} );


gulp.task( 'default', ['bower'], function() {
    // Does nothing in this task, just triggers the dependent 'watch'
} );
