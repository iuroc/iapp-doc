from tkinter import Tk
from tkinter.filedialog import askdirectory
import os
import re


def parse_text(text: str):
    '''
    预处理文本
    '''
    text = re.sub(r'】(\s*\n)*', r'】```java\n', text)
    text = re.sub(r'(\n\s*)*【', r'\n```【', text)
    text = re.sub(r'\\', r'\\\\', text)
    return text


'''
首选将官方文档的所有TXT文件放到一个文件夹
然后运行本程序，选择该文件夹即可
'''
Tk().withdraw()
path = askdirectory()
file_list = os.listdir(path)
for file_name in file_list:
    file_path = path + '/' + file_name
    if not os.path.isfile(file_path):
        continue
    file = open(file_path, 'r', encoding='utf-8')
    text = file.read()
    file.close()
    file2 = open(file_path, 'w', encoding='utf-8')
    text = parse_text(text)
    file2.write(text)
    file2.close()

print('处理完毕')
