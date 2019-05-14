
export function quickSort(arr) {
  if (arr.length < 2) {
    return arr
  } else {
    const pivot = arr[0]
    var less = arrayLessThen(arr, pivot)
    var greater = arrayGreaterThen(arr, pivot)
    // 数组合并
    less.push(pivot)
    less.push.apply(less, greater)
    return less
  }
}
function arrayLessThen(arr, pivot) {
  const result = []
  arr.forEach(function(item) {
    if (item <= pivot) {
      result.push(item)
    }
  })
  return result
}
function arrayGreaterThen(arr, pivot) {
  const result = []
  arr.forEach(function(item) {
    if (item > pivot) {
      result.push(item)
    }
  })
  return result
}
