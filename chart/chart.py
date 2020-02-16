import sys
import audiofile as af
import matplotlib
matplotlib.use('agg')
import matplotlib.pyplot as plt


def get_chart_title(suffix):
    mapping = {'_before' : 'Before processing', '_after' : 'After processing'}
    return mapping[suffix]

def get_basename(file_path):
    tokens = file_path.split('/')
    return tokens[-1]

def get_basename_no_format(file_path):
    basename = get_basename(file_path)
    tokens = basename.split('.')
    return tokens[0]

def get_format(file_path):
    basename = get_basename(file_path)
    tokens = basename.split('.')
    return tokens[-1]

def remove_white_margins():
    #no idea how this works, taken from stack overflow...
    plt.gca().set_axis_off()
    plt.subplots_adjust(top = 1, bottom = 0, right = 1, left = 0, hspace = 0, wspace = 0)
    plt.margins(0,0)
    plt.gca().xaxis.set_major_locator(plt.NullLocator())
    plt.gca().yaxis.set_major_locator(plt.NullLocator())


if len(sys.argv) < 3:
    raise NameError('Missing input filename!');

#get command line arguments
filename = sys.argv[1]
suffix = sys.argv[2]
output_file = sys.argv[3]

#read data and fs
file_info = af.read(filename)
samples = file_info[0]
fs = file_info[1]

#prepare the data
length = len(samples)
xvalues = map(lambda x: float(x) / fs, range(length))

#take care of axis legends etc.
axes = plt.gca() # gca - Get Chart Axes
axes.set_ylim([-1.0, 1.0])
axes.set_xlim([0, xvalues[-1]])
plt.title(get_chart_title(suffix))
plt.grid(True)
plt.xlabel('time [s]')

plt.plot(xvalues, samples)
plt.savefig(output_file)