var gulp = require('gulp'),
    del = require('del'),
    runSequence = require('run-sequence'),
    rename = require("gulp-rename");

const OUTPUT_PATH = '../../FishSauceDistribution/dist';

const FOLDERS = ['app', 'bootstrap', 'config', 'database', 'routes', 'resources/lang', 'resources/views'];

const PATHS = [
    {
        src: ['public/**/*', 'public/**/.*', '!public/index.php', '!public/index.apache.php'],
        dest: ''
    },
    {
        src: ['.htaccess'],
        dest: ''
    },
    {
        src: ['storage/**/.*'],
        dest: '/storage'
    },
    {
        src: ['.env.example', 'artisan', 'server.php', 'composer.json', 'composer.lock'],
        dest: ''
    }
];

const RENAME_PATHS = [
    {
        src: 'public/index.apache.php',
        new_name: 'index.php',
        dest: ''
    }
];

// DELETE BUILD FOLDER
gulp.task('clean', function(){
    return del(OUTPUT_PATH, { force: true });
});

// COPY SOURCE CODE TO THE DISTRIBUTION FOLDER
gulp.task('build:source', function () {
    var copies = [];

    for (var i = 0; i < FOLDERS.length; i++){
        var sources = [FOLDERS[i] + '/**/*', FOLDERS[i] + '/**/.*'];
        var dest = OUTPUT_PATH + '/' + FOLDERS[i];
        copies.push(gulp.src(sources)
            .pipe(gulp.dest(dest)));
    }    

    for (var i = 0; i < PATHS.length; i++){
        copies.push(gulp.src(PATHS[i].src)
            .pipe(gulp.dest(OUTPUT_PATH + PATHS[i].dest)));
    }

    for (var i = 0; i < RENAME_PATHS.length; i++){
        copies.push(gulp.src(RENAME_PATHS[i].src)
            .pipe(rename(RENAME_PATHS[i].new_name))
            .pipe(gulp.dest(OUTPUT_PATH + RENAME_PATHS[i].dest)));
    }

    return copies;
});

gulp.task('build', function(callback){
    runSequence('clean', 'build:source', callback);
});

gulp.task('default', ['build']);

// COPY ADMIN THEME
gulp.task('copy:admin-theme', function (callback) {
    var copies = [];

    copies.push(gulp.src('./resources/themes/metronic_v5.1.5/dist/sites/base/**/*')
        .pipe(gulp.dest('./public/admin-assets/theme/sites')));

    copies.push(gulp.src('./resources/themes/metronic_v5.1.5/dist/vendors/base/**/*')
        .pipe(gulp.dest('./public/admin-assets/theme/vendors/base')));

    return copies;
});
