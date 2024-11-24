## C# 面试题



#### 1，以下是用C#实现找到数组中第二大的数字的算法：

```c#
int[] arr = { 10, 5, 20, 8, 12, 15 };
Console.WriteLine(f(arr));

static int f(int[] n)
{
	int max = n[0];
	int sec = n[0];

	foreach (var i in n)
	{
		if (i > max)
		{
			sec = max;
			max = i;
		}
		else if (i > sec && i != max)
		{
			sec = i;
		}
	}

	return sec;
}
```



#### 2，以下是一个用C#编写的函数，用来判断一个字符串是否是回文。

```c#
static bool f(string s)
{
	int left = 0;
	int right = s.Length - 1;

	while (left < right)
	{
		while (left < right && !char.IsLetterOrDigit(s[left])) left++;
		while (left < right && !char.IsLetterOrDigit(s[right])) right--;

		if (char.ToLower(s[left]) != char.ToLower(s[right])) return false;

		left++; right--;
	}

	return true;
}
```



#### 3，写一个函数，反转输入的字符串。

```c#
string input2 = "Hello";
Console.WriteLine(f(input2));

static string f(string s)
{
	char[] c = s.ToCharArray();
	Array.Reverse(c);
	return new string(c);
}
```



#### 4，判断字符串是否是回文

```c#
string input3 = "racecar";
Console.WriteLine(f(input3));

static bool f(string s)
{
	int l = 0;
	int r = s.Length - 1;

	while (l < r)
	{
		if (char.ToLower(s[l]) != char.ToLower(s[r])) return false;

		l++; r--;
	}

	return true;
}
```



#### 5，寻找数组中的最大值和最小值

```c#
int[] array = { 3, 5, 1, 9, 2 };
int max, min;
f(array, out max, out min);
Console.WriteLine($"max={max}, min={min}");

static void f(int[] a, out int max, out int min)
{
	max = a[0];
	min = a[0];
	foreach (var i in a)
	{
		if (i > max) max = i;
		if (i < min) min = i;
	}
}
```



#### 6，实现斐波那契数列

```c#
int n = 10;
Console.WriteLine(f(n));

static int f(int n)
{
	if (n <= 0) return 0;
	if (n == 1) return 1;

	int a = 0;
	int b = 1;

	for (var i = 2; i <= n; i++)
	{
		int temp = a + b;
		a = b;
		b = temp;
	}

	return b;
}
```



#### 7，删除数组中的重复元素

```c#
int[] array1 = { 1, 1, 2, 3, 3, 4, 5, 5 };
int[] n = f(array1);
Console.WriteLine(string.Join(", ", n));

static int[] f(int[] a)
{
	HashSet<int> set = new HashSet<int>(a);

	return set.ToArray();
}
```



#### 8，判断一个整数是否是素数

```c#
int num = 17;
Console.WriteLine(f(num));

static bool f(int n)
{
	if (n <= 1) return false;
	if (n == 2) return true;

	for (var i = 2; i <= Math.Sqrt(n); i++)
	{
		if (n % i == 0) return false;
	}

	return true;
}
```



#### 9，两数之和

```c#
int[] array3 = { 2, 7, 11, 15 };
int target = 9;
int[] n = f(array3, target);
Console.WriteLine($"1={n[0]}, 2={n[1]}");

static int[] f(int[] n, int t)
{
	Dictionary<int, int> d = new Dictionary<int, int>();

	for (var i = 0; i < n.Length; i++)
	{
		int c = t - n[i];

		if (d.ContainsKey(c))
		{
			return new int[] { d[c], i };
		}

		d[n[i]] = i;
	}

	throw new ArgumentException("Wrong");
}
```



#### 10，反转

```c#
string words = "hello world";

for (var i = 0; i < words.Length; i++)
{
	Console.Write(words[words.Length - 1 - i]);
}
```



#### 11，合并两个有序数组

```c#
int[] nums1 = { 1, 2, 3, 0, 0, 0 };
int m = 3;  // nums1中的有效元素数量是3，即{1, 2, 3}
int[] nums2 = { 2, 5, 6 };
int n = 3; // nums2中的有效元素数量是3，即{2, 5, 6}
f(nums1, m, nums2, n);
Console.WriteLine(string.Join(", ", nums1));

static void f(int[] n1, int a, int[] n2, int b)
{
	int i = a - 1;
	int j = b - 1;
	int k = a + b - 1;

	while (i >= 0 && j >= 0)
	{
		if (n1[i] > n2[j])
		{
			n1[k] = n1[i];
			i--;
		}
		else
		{
			n1[k] = n2[j];
			j--;
		}

		k--;
	}

	while (j >= 0)
	{
		n1[k] = n2[j];
		k--;
		j--;
	}
}
```



#### 12，移除元素

```c#
int[] nums = { 0, 1, 2, 2, 3, 0, 4, 2 };
int val = 2;
int l = f(nums, val);
Console.WriteLine(string.Join(", ", nums.Take(l)));

static int f(int[] n, int v)
{
	int k = 0;

	for (var i = 0; i < n.Length; i++)
	{
		if (n[i] != v)
		{
			n[k] = n[i];
			k++;
		}
	}

	return k;
}
```



#### 13，无重复字符的最长子串 无重复字符的最长子串

```c#
string s1 = "abcabcbb";
string s2 = "bbbbb";
string s3 = "pwwkew";

Console.WriteLine(LengthOfLongestSubstring(s1)); // 输出 3
Console.WriteLine(LengthOfLongestSubstring(s2)); // 输出 1
Console.WriteLine(LengthOfLongestSubstring(s3)); // 输出 3

static int LengthOfLongestSubstring(string s)
{
	HashSet<char> set = new HashSet<char>();
	int maxLength = 0;
	int left = 0;

	for (var i = 0; i < s.Length; i++)
	{
		while (set.Contains(s[i]))
		{
			set.Remove(s[left]);
			left++;
		}
		set.Add(s[i]);
		maxLength = Math.Max(maxLength, i - left + 1);
	}

	return maxLength;
}
```



#### 14，最后一个单词的长度

```c#
string s = "   fly me   to   the moon  ";
Console.WriteLine(LengthOfLastWord(s)); // 输出 4

static int LengthOfLastWord(string s)
{
	var ss = s.Split(new[] { ' ' }, StringSplitOptions.RemoveEmptyEntries);
	return ss.Length > 0 ? ss[ss.Length - 1].Length : 0;
}
```



#### 15，判断回文数判断回文数

```c#
int n = 121;
Console.WriteLine(IsPalindrome(n));

static bool IsPalindrome(int n)
{
	if (n < 0) return false;

	int x = n;
	int y = 0;

	while (n > 0)
	{
		int pop = n % 10;
		n /= 10;

		y = y * 10 + pop;
	}

	return x == y;
}
```



#### 16，两个数组的交集

```c#
int[] nums1 = { 1, 2, 2, 1 };
int[] nums2 = { 2, 2 };
int[] w = Intersection(nums1, nums2);
Console.WriteLine(string.Join(", ", w)); // 2

static int[] Intersection(int[] n1, int[] n2)
{
	HashSet<int> set = new HashSet<int>(n1);
	HashSet<int> res = new HashSet<int>();

	foreach (var i in n2)
	{
		if (set.Contains(i))
		{
			res.Add(i);
		}
	}

	return res.ToArray();
}
```



#### 17，打印五颗星（正三角形）

```c#
for (var i = 0; i < 5; i++)
{
	for (var j = 0; j <= i; j++)
		Console.Write("*");

	Console.WriteLine();
}
```



#### 18，打印五颗星（倒三角形）

```c#
for (var i = 5; i >= 1; i--)
{
	for (var j = 1; j <= i; j++)
		Console.Write("*");

	Console.WriteLine();
}
```



#### 19，打印矩形

```c#
for (var i = 0; i < 5; i++)
{
	for (var j = 0; j <= 5; j++)
		Console.Write("*");

	Console.WriteLine();
}
```



#### 20，计算数组的平均值

```c#
int[] n = { 1, 2, 3, 4, 5 };
Console.WriteLine(Average(n)); // 输出 "3"

static double Average(int[] n)
{
	int sum = 0;

	foreach (var i in n)
	{
		sum += i;
	}

	return (double)sum / n.Length;
}
```



#### 21，数组元素的平方和

```c#
int[] n = { 1, 2, 3 };
Console.WriteLine(SumOfSquares(n)); // 输出 "14"

static int SumOfSquares(int[] n)
{
	int sum = 0;

	foreach (var i in n)
	{
		sum += i * i;
	}

	return sum;
}
```



#### 22，问题：如何交换两个变量的值，不使用第三个变量？

```c#
int a = 5, b = 10;

a = a ^ b;
b = a ^ b;
a = a ^ b;

Console.WriteLine(a);
Console.WriteLine(b);
```



#### 23，问题：如何判断一个数是偶数还是奇数？

```c#
int number = 6;

if (number % 2 == 0)
{
	Console.WriteLine("O");
}
else
{
	Console.WriteLine("I");
}
```



#### 24，找出字符串中第一个匹配项的下标

```c#
string haystack1 = "sadbutsad";
string needle1 = "sad";
Console.WriteLine(StrStr(haystack1, needle1));  // Output: 0

static int StrStr(string s1, string s2)
{
	return s1.IndexOf(s2);
}
```



#### 25，移动零

```c#
int[] nums1 = { 0, 1, 0, 3, 12 };
MoveZeroes(nums1);
Console.WriteLine(string.Join(", ", nums1));  // Output: 1, 3, 12, 0, 0

static void MoveZeroes(int[] n)
{
	int zero = 0;

	for (var i = 0; i < n.Length; i++)
	{
		if (n[i] != 0)
		{
			n[zero] = n[i];
			zero++;
		}
	}

	for (var i = zero; i < n.Length; i++)
	{
		n[i] = 0;
	}

}
```



#### 26，多数元素

```c#
int[] nums1 = { 3, 2, 3 };
Console.WriteLine(MajorityElement(nums1));  // Output: 3

static int MajorityElement(int[] n)
{
	Dictionary<int, int> d = new Dictionary<int, int>();
	int done = n.Length / 2;

	foreach (int i in n)
	{
		if (d.ContainsKey(i))
		{
			d[i]++;
		}
		else
		{
			d[i] = 1;
		}

		if (d[i] > done)
		{
			return i;
		}
	}

	throw new ArgumentException("w");
}
```



#### 27，少数元素

```c#
int[] nums1 = { 2, 2, 1 };
Console.WriteLine(SingleNumber(nums1));  // Output: 1

static int SingleNumber(int[] n)
{
	int r = 0;
	foreach (var i in n)
	{
		r ^= i;
	}

	return r;
}
```



#### 28，删除数组中的重复元素

```c#
int[] ns = { 1, 2, 6, 7, 34, 5, 2, 1, 5, 8 };
int[] m = RemoveDuplicates(ns);
Console.WriteLine(string.Join(", ", m));

static int[] RemoveDuplicates(int[] numbers)
{
	return numbers.Distinct().ToArray();
}
```



#### 29，查找数组中重复的元素

```c#
int[] ns = { 1, 2, 6, 7, 34, 5, 2, 1, 5, 8 };
List<int> m = FindDuplicates(ns);
Console.WriteLine(string.Join(", ", m));

static List<int> FindDuplicates(int[] numbers)
{
	HashSet<int> set = new HashSet<int>();
	List<int> list = new List<int>();

	for (var i = 0; i < numbers.Length; i++)
	{
		if (set.Contains(numbers[i]))
		{
			list.Add(numbers[i]);
		}
		else
		{
			set.Add(numbers[i]);
		}
	}

	return list;
}
```



#### 30，计算字符串中的元音字母数量

```c#
string ss = "dsasdahgrev";
Console.WriteLine(CountVowels(ss));

static int CountVowels(string str)
{
	int c = 0;
	string a = "aeiouAEIOU";

	foreach (var i in str)
	{
		if (a.Contains(i))
		{
			c++;
		}
	}

	return c;
}
```



#### 31，检查数组是否为回文数组  前面学过了

```c#
int[] arr1 = { 1, 2, 3, 2, 1 };
Console.WriteLine(IsPalindrome(arr1));  // Output: True

int[] arr2 = { 1, 2, 3, 4, 5 };
Console.WriteLine(IsPalindrome(arr2));  // Output: False

static bool IsPalindrome(int[] arr)
{
	int l = 0;
	int r = arr.Length - 1;

	while (l < r)
	{
		if (arr[l] != arr[r]) return false;

		l++; r--;
	}

	return true;
}
```



#### 32，冒泡排序

```c#
int[] arr = { 64, 34, 25, 12, 22, 11, 90 };
Console.WriteLine("未排序的数组:");
Console.WriteLine(string.Join(" ", arr));

BubbleSort(arr);

Console.WriteLine("排序后的数组:");
Console.WriteLine(string.Join(" ", arr));

static void BubbleSort(int[] arr)
{
	for (var i = 0; i < arr.Length - 1; i++)
	{
		for (var j = 0; j < arr.Length - 1 - i; j++)
		{
			if (arr[j] > arr[j + 1])
			{
				int temp = arr[j];
				arr[j] = arr[j + 1];
				arr[j + 1] = temp;
			}
		}
	}
}
```



#### 33，Longest Palindromic Substring 最长的反折子串

```c#
string s = "babad";
Console.WriteLine(LongestPalindrome(s));

static string LongestPalindrome(string s)
{
	string res = "";

	for (int i = 0; i < s.Length; i++)
	{
		res = GetLonger(res, Expand(s, i, i));       // 奇数长度
		res = GetLonger(res, Expand(s, i, i + 1));   // 偶数长度
	}

	return res;
}

static string Expand(string s, int l, int r)
{
	while (l >= 0 && r < s.Length && s[l] == s[r]) 
	{
		l--; r++; 
	}
	return s.Substring(l + 1, r - l - 1);
}

static string GetLonger(string s1, string s2)
{
	return s1.Length > s2.Length ? s1 : s2;
}
```



#### 34，Reverse Integer 反向整数

```c#
int n = 123;
Console.WriteLine(Reverse(n));

static int Reverse(int x)
{
	int res = 0;

	while (x != 0)
	{
		int d = x % 10;
		x /= 10;
		res = res * 10 + d;
	}

	return res;
}
```



#### 35，Longest Common Prefix 最长通用前缀

```c#
string[] strs = { "flower", "flow", "flight" };
Console.WriteLine(LongestCommonPrefix(strs));

static string LongestCommonPrefix(string[] strs)
{
	if (strs.Length == 0) return "";
	string prefix = strs[0];  // 取第一个字符串作为初始前缀
	for (int i = 1; i < strs.Length; i++)
	{
		while (strs[i].IndexOf(prefix) != 0)
		{  // 检查每个字符串是否以当前前缀开头
			prefix = prefix.Substring(0, prefix.Length - 1);  // 如果不是，减少前缀长度
			if (prefix == "") return "";  // 如果前缀为空，返回空字符串
		}
	}
	return prefix;

}
```

