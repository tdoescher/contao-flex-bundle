import gulp from 'gulp';
import esbuild from 'gulp-esbuild';
import { sassPlugin } from 'esbuild-sass-plugin';

const styles = () => {
    return gulp.src([ 'src/Resources/public/grid.scss' ])
        .pipe(esbuild({
            target: [ 'es2020', 'chrome58', 'edge16', 'firefox57', 'node12', 'safari11' ],
            plugins: [ sassPlugin() ],
            minify: true,
            outfile: 'grid.min.css',
        }))
        .pipe(gulp.dest('src/Resources/public/'));
};

gulp.task('build', styles);
